<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;



class AdminAuthController extends Controller
{
    // Register a new admin with a unique admin code
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:admins',
            'password' => 'required|string',
            'admin_code' => 'required|string|exists:admin_codes,code',  // Ensure the code exists
        ]);

        // Check if the admin code is already used
        $adminCode = AdminCodes::where('code', $validated['admin_code'])->where('is_used', 0)->first();
        if (!$adminCode) {
            return response()->json(['message' => 'This admin code is invalid or already used.'], 422);
        }

        // Create the new admin
        $admin = Admin::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'admin_code_id' => $adminCode->id,
        ]);

        // Mark the admin code as used
        $adminCode->update(['is_used' => 1]);

        return response()->json(['message' => 'Admin registered successfully', 'admin' => $admin], 201);
    }

    // Admin login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        // Generate the token for the admin
        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully.',
            'token' => $token,
        ]);
    }

    // Admin logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}

