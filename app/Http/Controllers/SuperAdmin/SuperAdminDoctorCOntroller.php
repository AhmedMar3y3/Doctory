<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\City;
use App\Models\Specialization;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
class SuperAdminDoctorCOntroller extends Controller
{
    ///////////////// Superadmin methods/////////////////////

    public function loadDoctors()
    {
        $doctors = Doctor::with(['city', 'specialization'])->get();
        return view('superadmin.doctors.index', compact('doctors'));
    }
    public function createDoctor()
    {
        $cities = City::all();
        $specializations = Specialization::all();
        return view('superadmin.doctors.create', compact('cities', 'specializations'));
    }

    public function storeDoctor(StoreDoctorRequest $request)
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
            'admin_id' => auth('superadmin')->id(),
        ]));

        return redirect()->route('superadmin.doctors.index', compact('doctor'))->with('success', 'Doctor created successfully');
    }
    public function editDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $cities = City::all();
        $specializations = Specialization::all();
        return view('superadmin.doctors.edit', compact('doctor', 'cities', 'specializations'));
    }

    public function updateDoctor(UpdateDoctorRequest $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validated();
        $updateData = [];
        if ($request->hasFile('image')) {
            $updateData['image'] = $request->file('image')->store('images', 'public');
        }
        foreach (['name', 'price', 'details', 'waiting_time', 'address'] as $field) {
            if (array_key_exists($field, $validated)) {
                $updateData[$field] = $validated[$field];
            }
        }
        foreach (['city' => 'city_id', 'specialization' => 'specialization_id'] as $field => $foreignKey) {
            if (isset($validated[$field])) {
                $model = $field === 'city' ? City::class : Specialization::class;
                $instance = $model::where('name', $validated[$field])->firstOrFail();
                $updateData[$foreignKey] = $instance->id;
            }
        }

        $doctor->update($updateData);

        return redirect()->route('superadmin.doctors.index')->with('success', 'Doctor updated successfully');
    }

    public function deleteDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);    
        $doctor->delete();
         return redirect()->route('superadmin.doctors.index')->with('success', 'Doctor deleted successfully');
}
}
