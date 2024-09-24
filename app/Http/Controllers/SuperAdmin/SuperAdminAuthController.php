<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SuperAdminAuthController extends Controller
{
    public function loadLoginPage()
    {
        return view('superadmin.login');
    }

    public function register(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'email' => 'required|email|unique:super_admins', // Ensure this references the correct table
            'password' => 'required|string',
        ]);
        
        // Check if a super admin already exists
        if (SuperAdmin::count() > 0) {
            return response()->json(['message' => 'A super admin already exists.'], 403); // 403 Forbidden
        }

        // Create the super admin
        $admin = SuperAdmin::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json(['message' => 'Admin registered successfully', 'admin' => $admin], 201);
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('superadmin')->attempt($credentials)) {
            return redirect()->route('superadmin.dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // Admin logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('loginPage')->with('success', 'Logged out successfully.');
    }
}
