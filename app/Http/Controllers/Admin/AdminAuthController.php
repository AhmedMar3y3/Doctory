<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class AdminAuthController extends Controller
{
    public function loadLoginPage(){
        return view('Admin.login');
    }
    // Register a new admin with a unique admin code
    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:admins',
            'password' => 'required|string',
          //  'admin_code' => 'required|string|exists:admin_codes,code',
        ]);
        // $adminCode = AdminCodes::where('code', $validated['admin_code'])->where('is_used', 0)->first();
        // if (!$adminCode) {
        //     return response()->json(['message' => 'This admin code is invalid or already used.'], 422);
        // }
        $admin = Admin::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
         //   'admin_code_id' => $adminCode->id,
        ]);
     //   $adminCode->update(['is_used' => 1]);
        return response()->json(['message' => 'Admin registered successfully', 'admin' => $admin], 201);
    }

  

    // Admin login
   // Admin login
public function loginUser(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (Auth::guard('admin')->attempt($credentials)) {
        // Successful login, redirect to admin dashboard
        return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully.');
    }

    // Login failed, return error
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->withInput();
}


    // Admin logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('loginPage')->with('success', 'Logged out successfully.');
    }
}

