<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\City;
use App\Models\Specialization;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Storage;

class SuperAdminPharmacyController extends Controller
{
      ///////////////// Superadmin methods/////////////////////

      public function loadPharmacies()
      {
          $pharmacies = Pharmacy::get();
          return view('superadmin.pharmacies.index', compact('pharmacies'));
      }

      public function createPharmacy()
      {
          return view('superadmin.pharmacies.create');
      }

      public function storePharmacy(Request $request)
      {
          $validated = $request->validate([
              'name' => 'required|string|max:255',
              'phone' => 'required|string|max:15',
              'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          ]);
  
          $imagePath = $request->file('image')->store('pharmacies', 'public');
  
          $pharmacy = Pharmacy::create([
              'name' => $validated['name'],
              'phone' => $validated['phone'],
              'image' => $imagePath,
              'admin_id' => null,
          ]);
  
          return redirect()->route('superadmin.pharmacies.index')->with('success', 'Pharmacy created successfully.');
      }
  
    
      public function editPharmacy(string $id)
      {
          $pharmacy = Pharmacy::findOrFail($id);
          return view('superadmin.pharmacies.edit', compact('pharmacy'));
      }
  
      /**
       * Update the specified resource in storage.
       */
      public function updatePharmacy(Request $request, string $id)
      {
          $validated = $request->validate([
              'name' => 'nullable|string|max:255',
              'phone' => 'nullable|string|max:15',
              'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          ]);
  
          $pharmacy = Pharmacy::findOrFail($id);
  
          if ($request->hasFile('image')) {
              Storage::disk('public')->delete($pharmacy->image);
              $imagePath = $request->file('image')->store('pharmacies', 'public');
              $pharmacy->image = $imagePath;
          }
  
          $pharmacy->name = $validated['name'] ?? $pharmacy->name;
          $pharmacy->phone = $validated['phone'] ?? $pharmacy->phone;
  
          $pharmacy->save();
  
          return redirect()->route('superadmin.pharmacies.index')->with('success', 'Pharmacy updated successfully.');
      }
  
      public function deletePharmacy(string $id)
      {
          $pharmacy = Pharmacy::findOrFail($id);
          Storage::disk('public')->delete($pharmacy->image);
  
          $pharmacy->delete();
          return redirect()->route('superadmin.pharmacies.index')->with('success', 'Pharmacy deleted successfully.');
      }
}
