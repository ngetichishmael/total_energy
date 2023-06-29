<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SMS;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserCode;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB as FacadesDB;

/**
 * @group Authentication Api's
 *
 * APIs to manage the user Authentication.
 * */
class AuthController extends Controller
{

   /**
    * User Login
    *
    * @bodyParam email string required
    * @bodyParam password string required user password.
    * @response 200{
         "message": "Hi User Name, welcome",
         "access_token": "254|33icFsR8uIOF1KsOeaJ114ntrU8adIX7gitwAveK",
         "token_type": "Bearer"
      }
    **/
   public function userLogin(Request $request)
   {

      //(!Auth::attempt(['email' => $request->email, 'password' => $request->password], true))
      if (!FacadesAuth::attempt(['phone_number' => $request->email, 'password' => $request->password], true)) {
         return response()
            ->json(['message' => 'Unauthorized'], 401);
      }

      $user = User::where('phone_number', $request['email'])->firstOrFail();

      $token = $user->createToken('auth_token')->plainTextToken;

      return response()->json([
         "success" => true,
         "token_type" => 'Bearer',
         "message" => "User Logged in",
         "access_token" => $token,
         "user" => $user
      ]);
   }

   /**
    * User details
    * @param  string $email
    * @response 200{
                  "success": true,
                  "message": "Restaurants menu items",
                  "data": {
                        "id": .....,
                        "name": "Albert Einstein",
                        "email": "einstein@email.com",
                  }
      }
    **/
   public function user_details($email)
   {
      $user = User::where('email', $email)->first();
      return response()->json([
         "success" => true,
         "message" => "User Details",
         "data" => $user
      ]);
   }


   /**
    * Logout and delete token
    *
    *
    **/
   public function logout(Request $request)
   {
      $request->user()->currentAccessToken()->delete();

      return [
         'message' => 'You have successfully logged out'
      ];
   }


   /**
    * send otp
    *
    * @return response()
    */

   public function sendOTP($number)
   {


      $user = FacadesDB::table('users')->where('phone_number', $number)->first();

      if ($user) {
         try {

            $code = rand(100000, 999999);

            UserCode::updateOrCreate([
               'user_id' => $user->id,
               'code' => $code
            ]);
            $message = "Your reset OTP is  " . $code;
            info($message);
            (new SMS())($user->phone_number, $message);

            return response()->json(['data' => $user, 'otp' => $code]);
         } catch (ExceptionHandler $e) {
            return response()->json(['message' => 'Error occured while trying to send OTP code']);
         }
      } else {
         return response()->json(['message' => 'User is not registered!']);
      }
   }

   /**
    * verify otp
    *
    * @return response()
    */
   public function verifyOTP($number, $otp)
   {


      // $phone = $request->only('phone');
      // $phone = substr($validated['phone'], 1);
      // $phone = '+254'.$phone;
      // $phone = str_replace(' ', '', $phone);

      $user = DB::table('users')->where('phone_number', $number)->get();

      // return $user;

      $exists = UserCode::where('user_id', $user[0]->id)
         ->where('code', $otp)
         ->where('updated_at', '>=', now()->subMinutes(5))
         ->latest('updated_at')
         ->exists();

      if ($exists) {
         // DB::table('users')
         // ->where('id', $user->id)
         // ->update(['status' => 'activated']);
         //  Log::info('Valid OTP entered');
         return response()->json(['message' => 'Valid OTP entered']);
      }
      // Log::error('Invalid OTP entered');
      return response()->json(['message' => 'Invalid OTP entered']);
   }

   public function updatePassword(Request $request)
   {

      $request->validate([
         'phone_number' => 'required|string|exists:users',
         'password' => 'required|string|min:6|confirmed',
         'password_confirmation' => 'required',

      ]);

      $user = User::where('phone_number', $request->phone_number)
         ->update(['password' => Hash::make($request->password)]);


      return response()->json(['message' => 'Password has been changed sucessfully']);
      // DB::table('password_resets')->where(['email'=> $request->email])->delete();

   }
}
