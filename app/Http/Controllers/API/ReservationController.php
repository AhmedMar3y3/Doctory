<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function store(Request $request, $doctorId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'day' => 'required|string',
            'time' => 'required|string',
        ]);

        $doctor = Doctor::findOrFail($doctorId);

        $reservation = Reservation::create(array_merge($validated, [
            'doctor_id' => $doctor->id,
            'expires_at' => now()->addMinute()
        ]));
        return response()->json([
            'message' => 'Reservation created successfully',
            'reservation' => $reservation,
        ], 201);
    }

    /**
     * Display the user's reservations.
     */
    public function index()
    {
        $reservations = Reservation::with(['doctor' => function ($query) {
            $query->select('id', 'name', 'specialization_id', 'price')
                  ->with(['specialization' => function ($subQuery) {
                      $subQuery->select('id', 'name'); 
                  }]);
        }])->get();

        return response()->json($reservations);
    }
}
