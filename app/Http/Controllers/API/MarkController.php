<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Specialization;

class MarkController extends Controller
{

    public function getAllSpecializations()
    {
        $specializations = Specialization::all();
        return response()->json($specializations);
    }
    public function getAllCities()
    {
        $cities = City::all();
        return response()->json($cities);
    }
}
