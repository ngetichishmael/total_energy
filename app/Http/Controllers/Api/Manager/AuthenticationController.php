<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCode;
use App\Models\Region;
use App\Models\AssignedRegion;
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
        if (!Auth::attempt([
            'phone_number' => $request->phone_number,
            'password' => $request->password,
            function ($query) {
                $query->whereIn('account_type', ['Managers', 'Admin']);
            },
            'status' => 'Active'
        ], true)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $user = User::with(['mainRegion', 'assignedRegions'])->where('phone_number', $request['phone_number'])->firstOrFail();
    
        // Remove pivot information from assigned regions
        $assignedRegions = $user->assignedRegions->map(function ($region) {
            return [
                'id' => $region->id,
                'name' => $region->name,
                'primary_key' => $region->primary_key,
                'created_at' => $region->created_at,
                'updated_at' => $region->updated_at,
            ];
        });
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        $random = Str::random(20);
        $activityLog = new activity_log();
        $activityLog->source = 'Mobile App';
        $activityLog->activity = 'Manager Login in Mobile Device';
        $activityLog->user_code = auth()->user()->user_code;
        $activityLog->section = 'Mobile Login';
        $activityLog->action = 'User ' . auth()->user()->name . ' Logged in in mobile application';
        $activityLog->userID = auth()->user()->id;
        $activityLog->activityID = $random;
        $activityLog->ip_address = $request->ip() ?? '127.0.0.1';
        $activityLog->save();
    
        return response()->json([
            "success" => true,
            "token_type" => 'Bearer',
            "message" => "Successfully Log in",
            "access_token" => $token,
            "user" => [
                "id" => $user->id,
                "user_code" => $user->user_code,
                "name" => $user->name,
                "email" => $user->email,
                "email_verified_at" => $user->email_verified_at,
                "business_code" => $user->business_code,
                "phone_number" => $user->phone_number,
                "location" => $user->location,
                "gender" => $user->gender,
                "account_type" => $user->account_type,
                "status" => $user->status,
                "fcm_token" => $user->fcm_token,
                "admin_id" => $user->admin_id,
                "route_code" => $user->route_code,
                "created_at" => $user->created_at,
                "updated_at" => $user->updated_at,
                "main_region" => $user->mainRegion,
                // "other_assigned_regions" => $assignedRegions->all(), // Remove pivot information
            ],
        ]);
    }
    
    
    

    public function user_details($user_code)
    {
        $user = User::where('user_code', $user_code)->first();
    
        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "User not found"
            ], 404);
        }
    
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
    
                $message = "Total Energies : A request has been received to reset your account login credentials. To proceed with the password reset process, use this OTP: " . $code;
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
