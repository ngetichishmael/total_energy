<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCode;
use App\Helpers\SMS;
use App\Models\activity_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
   public function login(Request $request)
   {

      //(!Auth::attempt(['email' => $request->email, 'password' => $request->password], true))
      if (!Auth::attempt(
         [
            'phone_number' => $request->phone_number,
            'password' => $request->password,
            'account_type' =>'Managers',
            'status' =>'Active'
         ],
         true
      )) 
      
      {
         return response()
            ->json(['message' => 'Unauthorized'], 401);
      }

      $user = User::where('phone_number', $request['phone_number'])->firstOrFail();

      $token = $user->createToken('auth_token')->plainTextToken;

      $random = Str::random(20);
      $activityLog = new activity_log();
      $activityLog->source = 'Mobile App';
      $activityLog->activity = 'Manager Login in Mobile Device';
      $activityLog->user_code = auth()->user()->user_code;
      $activityLog->section = 'Mobile Login';
      $activityLog->action = 'User ' . auth()->user()->name . ' Logged in in mobile appication';
      $activityLog->userID = auth()->user()->id;
      $activityLog->activityID = $random;
      $activityLog->ip_address = $request->ip() ?? '127.0.0.1';
      $activityLog->save();

      return response()->json([
         "success" => true,
         "token_type" => 'Bearer',
         "message" => "Successfully Log in",
         "access_token" => $token,
         "user" => $user
      ]);
   }

   public function user_details($phone_number)
   {
      $user = User::where('phone_number', $phone_number)->first();
      return response()->json([
         "success" => true,
         "message" => "Manager Details",
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
      $user = $request->user();
      $user->currentAccessToken()->delete();

      $activityLog = new activity_log();
      $activityLog->source = 'Mobile App';
      $activityLog->activity = 'Logout from Mobile Device';
      $activityLog->user_code = $user->user_code;
      $activityLog->section = 'Mobile Logout';
      $activityLog->action = 'User ' . $user->name . ' Logged out from mobile application';
      $activityLog->userID = $user->id;
      $activityLog->activityID = Str::random(20);
      $activityLog->ip_address = $request->ip();
      $activityLog->save();

      return [
         'message' => 'Successfully log out'
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
                $recentCode = UserCode::where('user_id', $user->id)
                    ->where('created_at', '>=', now()->subMinutes(5))
                    ->latest('created_at')
                    ->first();
    
                if ($recentCode) {
                    return response()->json([
                        'message' => 'An OTP has already been sent. Try again after 5 minutes to request a new OTP.',
                        'data' => $user,
                        'recent_otp' => $recentCode->code,
                    ], 400);
                }
    
                $code = rand(100000, 999999);
    
                UserCode::updateOrCreate([
                    'user_id' => $user->id,
                    'code' => $code
                ]);
    
                $message = "A request has been received to reset your account login credentials. To proceed with the password reset process, use this OTP: " . $code;
                info($message);
                (new SMS())($user->phone_number, $message);
    
                return response()->json(['data' => $user, 'otp' => $code]);
            } catch (Exception $e) {
                return response()->json(['message' => 'Error occurred while trying to send OTP code'], 500);
            }
        } else {
            return response()->json(['message' => 'User not found!'], 404);
        }
    }
    
    
   // public function sendOTP($number)
   // {


   //    $user = FacadesDB::table('users')->where('phone_number', $number)->first();

   //    if ($user) {
   //       try {

   //          $code = rand(100000, 999999);

   //          UserCode::updateOrCreate([
   //             'user_id' => $user->id,
   //             'code' => $code
   //          ]);
   //          $message = "A request has been received to reset your account login credentials. To proceed with the password reset process, use this OTP: " . $code;
   //          info($message);
   //          (new SMS())($user->phone_number, $message);

   //          return response()->json(['data' => $user, 'otp' => $code]);
   //       } catch (ExceptionHandler $e) {
   //          return response()->json(['message' => 'Error occured while trying to send OTP code']);
   //       }
   //    } else {
   //       return response()->json(['message' => 'User not Found!'], 500);
   //    }
   // }

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
      $user = DB::table('users')->where('phone_number', $number)->first();

      if (!$user) {
          return response()->json(['message' => 'User not found'], 404);
      }
      
      // Further logic for sending SMS OTP and password reset goes here
      

      $exists = UserCode::where('user_id', $user->id)
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
       $validator = Validator::make($request->all(), [
           'phone_number' => 'required|string|exists:users',
           'password' => 'required|string|min:6|confirmed',
           'password_confirmation' => 'required',
       ]);
   
       if ($validator->fails()) {
         $firstError = $validator->errors()->first();
         return response()->json(['message' => $firstError], 400);
       }
       $user = User::where('phone_number', $request->phone_number)
           ->update(['password' => Hash::make($request->password)]);
   
       if ($user) {
           return response()->json(['message' => 'Password has been changed successfully']);
       } else {
           return response()->json(['message' => 'Failed to update password'], 500);
       }
   }
   

}
