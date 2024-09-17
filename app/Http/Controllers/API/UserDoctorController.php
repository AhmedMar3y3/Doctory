<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Specialization;

class UserDoctorController extends Controller
{
    public function getDoctorsBySpecialty(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|exists:specializations,name',
        ]);
        $specialization = Specialization::where('name', $validated['name'])->first();
        $doctors = Doctor::where('specialization_id', $specialization->id)->get();
        return response()->json($doctors);
    }
    public function getDoctorsByCity(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|exists:cities,name',
        ]);

        $city = City::where('name', $validated['name'])->first();
        $doctors = Doctor::where('city_id', $city->id)->get();
        return response()->json($doctors);
    }
}
