<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Problem;

class UserProblemController extends Controller
{
    
    public function submitProblem(Request $request)
    {
            $validatedData = $request->validate([
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image upload
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('problems', 'public'); // Store image in 'storage/app/public/problems'
        }
        $problem = Problem::create([
            'discreption' => $validatedData['description'],
            'image' => $imagePath, // Store the image path in the database
        ]);
        return response()->json([
            'message' => "Your problem has been submitted successfully",
            'problem' => $problem,
        ], 201); // Status 201 for resource creation
    }
}
