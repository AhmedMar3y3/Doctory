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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::with(['city', 'specialization'])->get();
        return response()->json($doctors);
    }

    /**
     * Store a newly created resource in storage.
     */
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

        return response()->json([
            'message' => 'Doctor created successfully',
            'doctor' => $doctor,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $doctor = Doctor::with(['city', 'specialization'])->findOrFail($id);
        return response()->json($doctor);
    }

    /**
     * Update the specified resource in storage.
     */
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

        return response()->json([
            'message' => 'Doctor updated successfully',
            'doctor' => $doctor,
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}
