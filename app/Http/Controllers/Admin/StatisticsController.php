<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pharmacy;
use App\Models\Offer;

class StatisticsController extends Controller
{
public function index()
{
    $totalAdmins = Admin::count();
    $totalUsers = User::count();
    $totalDoctors = Doctor::count();
    $totalPharmacies = Pharmacy::count();
    $totalOffers = Offer::count();
    $newUsersToday = User::whereDate('created_at', today())->count();
    return view('Admin.dashboard', 
    compact('totalUsers',
     'totalDoctors',
                'totalPharmacies',
                'totalOffers',
                'newUsersToday',
                'totalAdmins'));
}
}
