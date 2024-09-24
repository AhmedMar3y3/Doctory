<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\storeUserRequest;
use App\Http\Requests\loginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class UserAuthController extends Controller
{
    use HttpResponses;
    public function register(storeUserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);    
        $user = User::create($validatedData);
        $verificationCode = mt_rand(100000, 999999);
        $user->verification_code = $verificationCode;
        $user->save();
        Mail::raw("Your email verification code is: $verificationCode", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Verify Your Email');
        });
    
        return $this->Success([
            'user' => $user,
            'message' => 'Registration successful. Please verify your email with the PIN code sent to your email.'
        ]);
    }
    public function verifyEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'verification_code' => 'required|numeric',
    ]);

    $user = User::where('email', $request->email)
                ->where('verification_code', $request->verification_code)
                ->first();

    if (!$user) {
        return $this->error( 'Invalid verification code or email', 400);
    }

    $user->verified_at = now();
    $user->verification_code = null;
    $user->save();

    return $this->success(['message' => 'Email verified successfully']);
}

    

public function login(loginUserRequest $request)
{
    $validatedData = $request->validated();
    $user = User::where('email', $request->input('email'))->first();
    if (!$user || !Hash::check($request->input('password'), $user->password)) {
        return $this->error( "Credentials do not match", 404);
    }
    if (is_null($user->verified_at)) {
        return $this->error( "Please verify your email before logging in.", 403);
    }
    $token = $user->createToken('Api token of ' . $user->name)->plainTextToken;

    return $this->Success([
        'user' => $user,
        'token' => $token
    ]);
}

  
   public function logout(){
       Auth::user()->currentAccessToken()->delete();
       return $this->success([
           'message'=> Auth::user()->name .' ,you have successfully logged out and your token has been deleted'
       ]);
   }

   public function forgotPassword(Request $request)
   {
       $request->validate(['email' => 'required|email']);
   
       $user = User::where('email', $request->email)->first();
   
       if (!$user) {
           return $this->error(['email' => 'User not found'], 404);
       }
   
       // Generate a random 6-digit code
       $code = mt_rand(100000, 999999);
   
       DB::table('password_reset_tokens')->updateOrInsert(
           ['email' => $request->email],
           [
               'token' => $code,
               'created_at' => now()
           ]
       );
   
       // Send the code via gmail
       Mail::raw("Your password reset code is: $code", function ($message) use ($user) {
           $message->to($user->email)
               ->subject('Password Reset Code');
       });
   
       return $this->success(['message' => 'Password reset code sent to your email']);
   }
   
public function resetPassword(Request $request)
{
   $request->validate([
       'email' => 'required|email',
       'code' => 'required|numeric',
       'password' => 'required|min:6|confirmed',
   ]);

   // Retrieve the password reset entry
   $resetEntry = DB::table('password_reset_tokens')
       ->where('email', $request->email)
       ->where('token', $request->code)
       ->first();

 if (!$resetEntry) {
        return response()->json([
            'message' => 'Invalid code',
        ]);    }
   // Reset the user's password
   $user = User::where('email', $request->email)->first();
   $user->password = Hash::make($request->password);
   $user->save();

   // Delete the password reset entry
   DB::table('password_reset_tokens')->where('email', $request->email)->delete();
   return response()->json([
    'message' => 'Password has been reset successfully',
]);}  
}
