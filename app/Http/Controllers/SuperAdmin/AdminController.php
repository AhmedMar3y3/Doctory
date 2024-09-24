<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $totalAdmins = Admin::count();
        $admins = Admin::all();
        return view('superadmin.admins.index', compact('totalAdmins', 'admins'));
    }

    // Create an admin form page
    public function createAdminForm()
    {
        return view('superadmin.admins.create');
    }

    // Create an admin
    public function createAdmin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:admins',
            'name' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        Admin::create([
            'email' => $validated['email'],
            'name' => $validated['name'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('superadmin.admins.index')->with('success', 'Admin created successfully.');
    }

    // Delete an admin
    public function deleteAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('superadmin.admins.index')->with('success', 'Admin deleted successfully.');
    }
}
