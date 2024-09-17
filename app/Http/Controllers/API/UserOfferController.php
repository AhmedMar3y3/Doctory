<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Offer;
use App\Models\Specialization;

class UserOfferController extends Controller
{
    public function getOffersBySpecialty(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|exists:specializations,name',
        ]);

        $specialization = Specialization::where('name', $validated['name'])->first();
        $doctors = Offer::where('specialization_id', $specialization->id)->get();

        return response()->json($doctors);
    }
}
