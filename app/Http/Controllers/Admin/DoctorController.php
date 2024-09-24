<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\City;
use App\Models\Specialization;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    /////////////////user methods/////////////////////
    public function getAll()
    {
        $doctors = Doctor::with(['city', 'specialization'])->get();
        return response()->json($doctors);
    }

    public function getOne($id)
    {
        $doctor = Doctor::with(['city', 'specialization'])->findOrFail($id);
        return response()->json($doctor);
    }

    /////////////////admin methods/////////////////////

    public function index()
    {
        if (auth('superadmin')->check()) {
            $doctors = Doctor::with(['city', 'specialization'])->get(); // This fetches all doctors for superadmin
        } elseif (auth('admin')->check()) {
            // Log or debug admin_id to ensure correct admin is authenticated
            $adminId = auth('admin')->id();
            Log::info('Admin ID: ' . $adminId);
    
            // Fetch doctors belonging only to this admin
            $doctors = Doctor::with(['city', 'specialization'])
                ->where('admin_id', $adminId) // Filter by authenticated admin's ID
                ->get();
        } else {
            abort(403, 'Unauthorized');
        }
    
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $cities = City::all();
        $specializations = Specialization::all();
        return view('admin.doctors.create', compact('cities', 'specializations'));
    }

    public function store(StoreDoctorRequest $request)
    {
        $validated = $request->validated();
        $city = City::where('name', $validated['city'])->firstOrFail();
        $specialization = Specialization::where('name', $validated['specialization'])->firstOrFail();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }
        $doctor = Doctor::create(array_merge($validated, [
            'city_id' => $city->id,
            'specialization_id' => $specialization->id,
            'admin_id' => auth('admin')->id(),
        ]));
        Log::info('Doctor Created with Admin ID: ' . $doctor->admin_id);


        return redirect()->route('admin.doctors.index', compact('doctor'))->with('success', 'Doctor created successfully');
    }

    public function show($id)
    {
        $doctor = Doctor::with(['city', 'specialization'])->findOrFail($id);
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        $cities = City::all();
        $specializations = Specialization::all();
        return view('admin.doctors.edit', compact('doctor', 'cities', 'specializations'));
    }

    public function update(UpdateDoctorRequest $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
    
        // Check if the user is a super admin or the creator of the doctor
        if (!auth('superadmin')->check() && $doctor->admin_id !== auth('admin')->id()) {
            abort(403, 'Unauthorized');
        }
    
        $validated = $request->validated();
        $updateData = [];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $updateData['image'] = $request->file('image')->store('images', 'public');
        }
    
        // Update fields
        foreach (['name', 'price', 'details', 'waiting_time', 'address'] as $field) {
            if (array_key_exists($field, $validated)) {
                $updateData[$field] = $validated[$field];
            }
        }
    
        // Handle foreign key updates for city and specialization
        foreach (['city' => 'city_id', 'specialization' => 'specialization_id'] as $field => $foreignKey) {
            if (isset($validated[$field])) {
                $model = $field === 'city' ? City::class : Specialization::class;
                $instance = $model::where('name', $validated[$field])->firstOrFail();
                $updateData[$foreignKey] = $instance->id;
            }
        }
    
        // Update the doctor record
        $doctor->update($updateData);
    
        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully');
    }
    
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
    
        // Check if the user is a super admin or the creator of the doctor
        if (auth('superadmin')->check()) {
            $doctor->delete();
            return redirect()->route('superadmin.doctors.index')->with('success', 'Doctor deleted successfully');
        } elseif (auth('admin')->check()) {
            $adminId = auth('admin')->id();
            if ($doctor->admin_id !== $adminId) {
                abort(403, 'Unauthorized');
            }
            $doctor->delete();
            return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully');
        } else {
            abort(403, 'Unauthorized');
        }
    }
    
}