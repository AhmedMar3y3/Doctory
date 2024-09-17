<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function profile(Request $request)
    {
        // Get the authenticated user
        /** @var User $user */
        $user = Auth::user();

        return response()->json([
            'message' => 'Profile retrieved successfully.',
            'profile' => $user,
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        // Get the authenticated user
        /** @var User $user */
        $user = Auth::user();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|min:6|confirmed',
            'birthdate' => 'sometimes|date',
            'is_male' => 'sometimes|boolean',
        ]);
        if ($request->has('name')) {
            $user->name = $validatedData['name'];
        }

        if ($request->has('email')) {
            $user->email = $validatedData['email'];
        }

        if ($request->has('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        if ($request->has('birthdate')) {
            $user->birthdate = $validatedData['birthdate'];
        }

        if ($request->has('is_male')) {
            $user->is_male = $validatedData['is_male'];
        }

        $user->save();
        return response()->json([
            'message' => 'Profile updated successfully.',
            'profile' => $user,
        ], 200);
    }
    public function changePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        // Check if the current password is correct
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json([
                'message' => 'The current password is incorrect.',
            ], 400);
        }

        $user->password = Hash::make($validatedData['new_password']);
        $user->save();
        return response()->json([
            'message' => 'Password changed successfully.',
        ], 200);
    }
}
