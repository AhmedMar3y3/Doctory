<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\Offer;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    public function dashboard()
{
    $totalAdmins = Admin::count();
    $totalUsers = User::count();
    $newUsersToday = User::whereDate('created_at', Carbon::today())->count();
    $totalDoctors = Doctor::count();
    $totalPharmacies = Pharmacy::count();
    $totalOffers = Offer::count();
    $newUsersToday = User::whereDate('created_at', today())->count();
    return view('superadmin.dashboard', 
    compact('totalUsers',
     'totalDoctors',
                'totalPharmacies',
                'totalOffers',
                'newUsersToday',
                'totalAdmins',
                'newUsersToday'));
}
public function dash()
{
    $totalAdmins = Admin::count();
    $totalUsers = User::count();
    $totalDoctors = Doctor::count();
    $totalPharmacies = Pharmacy::count();
    $totalOffers = Offer::count();
    $newUsersToday = User::whereDate('created_at', today())->count();
    return view('superadmin.dash', compact('totalUsers', 'totalDoctors', 'totalPharmacies', 'totalOffers', 'newUsersToday', 'totalAdmins'));
}
}
