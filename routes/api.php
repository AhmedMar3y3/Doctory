<?php

use App\Http\Controllers\API\UserAuthController;
use App\Http\Controllers\API\UserProblemController;
use App\Http\Controllers\API\UserProfileController;
use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\PharmacyController;
use App\Http\Controllers\API\MarkController;
use App\Http\Controllers\API\UserDoctorController;
use App\Http\Controllers\API\UserOfferController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;

//////////////////////////  User Public Routes  //////////////////////////
Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/verify-email', [UserAuthController::class, 'verifyEmail']);
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/forgot-password', [UserAuthController::class, 'forgotPassword']);
Route::post('/reset-password', [UserAuthController::class, 'resetPassword']);

//////////////////////////  User Protected Routes  //////////////////////////
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [UserAuthController::class, 'logout']);
    Route::post('/problem', action: [UserProblemController::class, 'submitProblem']);
    Route::get('/profile', action: [UserProfileController::class, 'profile']);
    Route::post('/update-profile', [UserProfileController::class, 'updateProfile']);
    Route::post('/change-password', [UserProfileController::class, 'changePassword']);
    Route::get('/doctors/{doctor}', [DoctorController::class, 'getOne']);
    Route::get('/doctors', [DoctorController::class, 'getAll']);
    Route::post('/doctorsBySpecialization', [UserDoctorController::class, 'getDoctorsBySpecialty']);
    Route::post('/doctorsByCity', [UserDoctorController::class, 'getDoctorsByCity']);
    Route::post('/getOffersBySpecialization', [UserOfferController::class, 'getOffersBySpecialty']);
    Route::get('/pharmacies', [PharmacyController::class, 'getAll']);
    Route::get('/offers', [OfferController::class, 'getAll']);
    Route::get('/offers/{offer}', [OfferController::class, 'show']);
    Route::post('/doctors/{doctorId}/reserve', [ReservationController::class, 'store']);
    Route::get('/reservations', [ReservationController::class, 'index']);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//////////////////////////  Admin Public Routes  //////////////////////////
Route::post('/admin/register', [AdminAuthController::class, 'register']);


//////////////////////////  superAdmin Public Routes  //////////////////////////
Route::post('/register/superadmin',[SuperAdminAuthController::class,'register']);



//////////////////////////  Mark Public Routes  //////////////////////////
Route::get('/specializations', [MarkController::class, 'getAllSpecializations']);
Route::get('/cities', [MarkController::class, 'getAllCities']);

