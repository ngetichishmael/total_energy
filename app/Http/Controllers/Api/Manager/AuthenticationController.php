<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
   public function login(Request $request)
   {

      //(!Auth::attempt(['email' => $request->email, 'password' => $request->password], true))
      if (!Auth::attempt(
         [
            'email' => $request->email,
            'password' => $request->password,
            'account_type' =>'Manager'
         ],
         true
      )) {
         return response()
            ->json(['message' => 'Unauthorized'], 401);
      }

      $user = User::where('email', $request['email'])->firstOrFail();

      $token = $user->createToken('auth_token')->plainTextToken;

      return response()->json([
         "success" => true,
         "token_type" => 'Bearer',
         "message" => "User Logged in",
         "access_token" => $token,
         "user" => $user
      ]);
   }
}
