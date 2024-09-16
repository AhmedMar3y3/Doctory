<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Models\City;
use App\Models\Specialization;

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
        $doctors = Doctor::with(['city', 'specialization'])->get();
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
        ]));

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor created successfully');
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

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully');
    }
}
