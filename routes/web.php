<?php

use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PharmacyController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\SuperAdminDoctorCOntroller;
use App\Http\Controllers\SuperAdmin\SuperAdminOfferController;
use App\Http\Controllers\SuperAdmin\SuperAdminPharmacyController;

Route::get('/', [AdminAuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login/user', [AdminAuthController::class, 'loginUser'])->name('loginUser');
    ////////////////////////////////////////////////Admin routes/////////////////////////////////////////////////////////////////////////////////
    Route::middleware(['auth.admin'])->group(function () {
    Route::get('/admin/dashboard', [StatisticsController::class, 'index'])->name('admin.dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');                                       
    
      //Pharmacy routes
      Route::get('/admin/pharmacies', [PharmacyController::class, 'index'])->name('admin.pharmacies.index');
    Route::get('/admin/pharmacies/create', [PharmacyController::class, 'create'])->name('admin.pharmacies.create');
    Route::post('/admin/pharmacies', [PharmacyController::class, 'store'])->name('admin.pharmacies.store');
    Route::get('/admin/pharmacies/{id}/edit', [PharmacyController::class, 'edit'])->name('admin.pharmacies.edit');
    Route::put('/admin/pharmacies/{id}', [PharmacyController::class, 'update'])->name('admin.pharmacies.update');
    Route::delete('/admin/pharmacies/{id}', [PharmacyController::class, 'destroy'])->name('admin.pharmacies.destroy');

      //Offer routes
      Route::get('/admin/offers', [OfferController::class, 'index'])->name('admin.offers.index');
      Route::get('/admin/offers/create', [OfferController::class, 'create'])->name('admin.offers.create');
      Route::post('/admin/offers', [OfferController::class, 'store'])->name('admin.offers.store');
      Route::get('/admin/offers/{id}/edit', [OfferController::class, 'edit'])->name('admin.offers.edit');
      Route::put('/admin/offers/{id}', [OfferController::class, 'update'])->name('admin.offers.update');
      Route::delete('/admin/offers/{id}', [OfferController::class, 'destroy'])->name('admin.offers.destroy');

      //Doctor routes
      Route::prefix('admin/doctors')->name('admin.doctors.')->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->name('index');
        Route::get('/create', [DoctorController::class, 'create'])->name('create');
        Route::post('/', [DoctorController::class, 'store'])->name('store');
        Route::get('/{doctor}/edit', [DoctorController::class, 'edit'])->name('edit');
        Route::put('/{doctor}', [DoctorController::class, 'update'])->name('update');
        Route::delete('/{doctor}', [DoctorController::class, 'destroy'])->name('destroy');
    });
});

//////////////////////////////////////////////End of Admin routes/////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////SuperAdmin routes/////////////////////////////////////////////////////////////////////////////////
// SuperAdmin login page
Route::get('/superadmin/login', [SuperAdminAuthController::class, 'loadLoginPage'])->name('superadmin.loginPage');
// SuperAdmin login post request
Route::post('/superadmin/login', [SuperAdminAuthController::class, 'loginUser'])->name('superadmin.login');

  Route::middleware(['auth.superadmin'])->group(function () {
   Route::get('superadmin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');

   ////////////////////////////////////////////////Admins routes/////////////////////////////////////////////////////////////////////////////////
  Route::get('superadmin/admins/index', [AdminController::class, 'index'])->name('superadmin.admins.index');
  Route::get('superadmin/admins/create-admin', [AdminController::class, 'createAdminForm'])->name('superadmin.admins.createAdminForm');
  Route::post('superadmin/admins/create-admin', [AdminController::class, 'createAdmin'])->name('superadmin.admins.createAdmin');
  Route::delete('superadmin/admins/admin/{id}', [AdminController::class, 'deleteAdmin'])->name('superadmin.admins.deleteAdmin');

  ////////////////////////////////////////////////Doctors routes/////////////////////////////////////////////////////////////////////////////////
  Route::get('superadmin/doctors', [SuperAdminDoctorCOntroller::class, 'loadDoctors'])->name('superadmin.doctors.index');
  Route::get('superadmin/doctors/create', [SuperAdminDoctorCOntroller::class, 'createDoctor'])->name('superadmin.doctors.create');
  Route::post('superadmin/doctors', [SuperAdminDoctorCOntroller::class, 'storeDoctor'])->name('superadmin.doctors.store');
  Route::delete('superadmin/doctors/{doctor}', [SuperAdminDoctorCOntroller::class, 'deleteDoctor'])->name('superadmin.doctors.delete');
  Route::get('superadmin/doctors/{doctor}/edit', [SuperAdminDoctorCOntroller::class, 'editDoctor'])->name('superadmin.doctors.edit');
  Route::put('superadmin/doctors/{doctor}', [SuperAdminDoctorCOntroller::class, 'updateDoctor'])->name('superadmin.doctors.update');

  ////////////////////////////////////////////////Pharmacies routes/////////////////////////////////////////////////////////////////////////////////
  Route::get('superadmin/pharmacies', [SuperAdminPharmacyController::class, 'loadPharmacies'])->name('superadmin.pharmacies.index');
  Route::get('superadmin/pharmacies/create', [SuperAdminPharmacyController::class, 'createPharmacy'])->name('superadmin.pharmacies.create');
  Route::post('superadmin/pharmacies', [SuperAdminPharmacyController::class, 'storePharmacy'])->name('superadmin.pharmacies.store');
  Route::delete('superadmin/pharmacies/{pharmacy}', [SuperAdminPharmacyController::class, 'deletePharmacy'])->name('superadmin.pharmacies.delete');
  Route::get('superadmin/pharmacies/{pharmacy}/edit', [SuperAdminPharmacyController::class, 'editPharmacy'])->name('superadmin.pharmacies.edit');
  Route::put('superadmin/pharmacies/{pharmacy}', [SuperAdminPharmacyController::class, 'updatePharmacy'])->name('superadmin.pharmacies.update');

  ////////////////////////////////////////////////Offers routes/////////////////////////////////////////////////////////////////////////////////
  Route::get('superadmin/offers', [SuperAdminOfferController::class, 'loadOffers'])->name('superadmin.offers.index');
  Route::get('superadmin/offers/create', [SuperAdminOfferController::class, 'createOffers'])->name('superadmin.offers.create');
  Route::post('superadmin/offers', [SuperAdminOfferController::class, 'storeOffers'])->name('superadmin.offers.store');
  Route::delete('superadmin/offers/{offer}', [SuperAdminOfferController::class, 'deleteOffers'])->name('superadmin.offers.delete');
  Route::get('superadmin/offers/{offer}/edit', [SuperAdminOfferController::class, 'editOffers'])->name('superadmin.offers.edit');
  Route::put('superadmin/offers/{offer}', [SuperAdminOfferController::class, 'updateOffers'])->name('superadmin.offers.update');
});

