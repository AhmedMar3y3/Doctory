<?php

use App\Http\Controllers\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PharmacyController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\DoctorController;


Route::get('/', [AdminAuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login/user', [AdminAuthController::class, 'loginUser'])->name('loginUser');
// Protecting the dashboard route to be accessible only by authenticated admins
Route::middleware(['auth'])->group(function () {
    ////////////////////////////////////////////////Admin routes///////////////////////////////////////////////////
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // This should be your dashboard view
    })->name('admin.dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
      ///////////////////////////////////////////////////Pharmacy routes///////////////////////////////////////////////////
      Route::get('/admin/pharmacies', [PharmacyController::class, 'index'])->name('admin.pharmacies.index');
    Route::get('/admin/pharmacies/create', [PharmacyController::class, 'create'])->name('admin.pharmacies.create');
    Route::post('/admin/pharmacies', [PharmacyController::class, 'store'])->name('admin.pharmacies.store');
    Route::get('/admin/pharmacies/{id}/edit', [PharmacyController::class, 'edit'])->name('admin.pharmacies.edit');
    Route::put('/admin/pharmacies/{id}', [PharmacyController::class, 'update'])->name('admin.pharmacies.update');
    Route::delete('/admin/pharmacies/{id}', [PharmacyController::class, 'destroy'])->name('admin.pharmacies.destroy');

      ///////////////////////////////////////////////////Offer routes///////////////////////////////////////////////////
      Route::get('/admin/offers', [OfferController::class, 'index'])->name('admin.offers.index');
      Route::get('/admin/offers/create', [OfferController::class, 'create'])->name('admin.offers.create');
      Route::post('/admin/offers', [OfferController::class, 'store'])->name('admin.offers.store');
      Route::get('/admin/offers/{id}/edit', [OfferController::class, 'edit'])->name('admin.offers.edit');
      Route::put('/admin/offers/{id}', [OfferController::class, 'update'])->name('admin.offers.update');
      Route::delete('/admin/offers/{id}', [OfferController::class, 'destroy'])->name('admin.offers.destroy');

      ///////////////////////////////////////////////////Doctor routes///////////////////////////////////////////////////
      Route::prefix('admin/doctors')->name('admin.doctors.')->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->name('index');
        Route::get('/create', [DoctorController::class, 'create'])->name('create');
        Route::post('/', [DoctorController::class, 'store'])->name('store');
        Route::get('/{doctor}/edit', [DoctorController::class, 'edit'])->name('edit');
        Route::put('/{doctor}', [DoctorController::class, 'update'])->name('update');
        Route::delete('/{doctor}', [DoctorController::class, 'destroy'])->name('destroy');
    });
});