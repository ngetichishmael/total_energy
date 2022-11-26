<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\customer\customers;
use App\Http\Controllers\Controller;
use App\Models\UserCode;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller
{
   public function customerLogin(Request $request)
   {

      //(!Auth::attempt(['email' => $request->email, 'password' => $request->password], true))
      if (!Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password], true)) {
         return response()
            ->json(['message' => 'Unauthorized'], 401);
      }

      $user = User::where('phone_number', $request['phone_number'])->firstOrFail();

      $token = $user->createToken('auth_token')->plainTextToken;

      return response()->json([
         "success" => true,
         "token_type" => 'Bearer',
         "message" => "User Logged in",
         "access_token" => $token,
         "user" => $user
      ]);
   }
   public function logout(Request $request)
   {
      $request->user()->currentAccessToken()->delete();

      return [
         'message' => 'You have successfully logged out'
      ];
   }
   public function registerCustomer(Request $request)
   {
      $validator           =  Validator::make($request->all(), [
         "customer_name"   => "required|unique:customers",
         "phone_number"    => "required|unique:customers",
         "Latitude"        => "required",
         "Longitude"       => "required",
         "image" => 'required|image|mimes:jpg,png,jpeg,gif,svg',
      ]);

      if ($validator->fails()) {
         return response()->json(
            [
               "status" => 401,
               "message" =>
               "validation_error",
               "errors" => $validator->errors()
            ],
            403
         );
      }

      $image_path = $request->file('image')->store('image', 'public');
      $account = Str::random(20);
      customers::create([
         'customer_name' => $request->customer_name,
         'account' => $account,
         'approval' => "Approved",
         'address' => $request->Address,
         'country' => "Kenya",
         'latitude' => $request->Latitude,
         'longitude' => $request->Longitude,
         'contact_person' => $request->ContactPerson,
         'phone_number' => $request->phone_number,
         'Telephone' => $request->phone_number,
         'customer_group' => $request->CustomerLevel,
         'route' => $request->Address,
         'status' => "Active",
         'email' => $request->email,
         'image' => $image_path,
         'business_code' => $account,
         'created_by' => $account,
         'updated_by' => $account,
      ]);
      User::create([
         'user_code' => $account,
         'name' => $request->customer_name,
         'email' => $request->email ?? $request->phone_number . '@gmail.com',
         'password' => Hash::make($request->phone_number),
         'business_code' => $account,
         'phone_number' => $request->phone_number,
         'location' => $request->Address,
         'account_type' => "Customer",
         'status' => "Active",
      ]);
      $user = User::where('phone_number', $request->phone_number)->firstOrFail();

      $token = $user->createToken('auth_token')->plainTextToken;

      return response()->json([
         "success" => true,
         "token_type" => 'Bearer',
         "message" => "User Logged in",
         "access_token" => $token,
         "user" => $user
      ]);
   }
   public function sendOTP($number)
   {


      $user = DB::table('users')->where('phone_number', $number)->get();

      if ($user) {
         try {

            $code = rand(100000, 999999);

            UserCode::updateOrCreate([
               'user_id' => $user[0]->id,
               'code' => $code
            ]);

            $curl = curl_init();

            curl_setopt_array($curl, array(
               CURLOPT_URL => 'https://prsp.jambopay.co.ke/api/api/org/disburseSingleSms/',
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_ENCODING => '',
               CURLOPT_MAXREDIRS => 10,
               CURLOPT_TIMEOUT => 0,
               CURLOPT_FOLLOWLOCATION => true,
               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
               CURLOPT_CUSTOMREQUEST => 'POST',
               CURLOPT_POSTFIELDS => '{
                "number" : "' . $number . '",
                "sms" : ' . $code . ',
                "callBack" : "https://....",
                "senderName" : "PASANDA"
          }
          ',
               CURLOPT_HTTPHEADER => array(
                  'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJwYXlsb2FkIjp7ImlkIjozNywibmFtZSI6IkRldmVpbnQgTHRkIiwiZW1haWwiOiJpbmZvQGRldmVpbnQuY29tIiwibG9jYXRpb24iOiIyMyBPbGVuZ3VydW9uZSBBdmVudWUsIExhdmluZ3RvbiIsInBob25lIjoiMjU0NzQ4NDI0NzU3IiwiY291bnRyeSI6IktlbnlhIiwiY2l0eSI6Ik5haXJvYmkiLCJhZGRyZXNzIjoiMjMgT2xlbmd1cnVvbmUgQXZlbnVlIiwiaXNfdmVyaWZpZWQiOmZhbHNlLCJpc19hY3RpdmUiOmZhbHNlLCJjcmVhdGVkQXQiOiIyMDIxLTExLTIzVDEyOjQ5OjU2LjAwMFoiLCJ1cGRhdGVkQXQiOiIyMDIxLTExLTIzVDEyOjQ5OjU2LjAwMFoifSwiaWF0IjoxNjQ5MzEwNzcxfQ.4y5XYFbC5la28h0HfU6FYFP5a_6s0KFIf3nhr3CFT2I',
                  'Content-Type: application/json'
               ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

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
      $user = DB::table('users')->where('phone_number', $number)->get();


      $exists = UserCode::where('user_id', $user[0]->id)
         ->where('code', $otp)
         ->where('updated_at', '>=', now()->subMinutes(5))
         ->latest('updated_at')
         ->exists();

      if ($exists) {
         return response()->json(
            [
               'message' =>
               'Valid OTP entered'
            ]
         );
      }
      return response()->json(
         [
            'message' => 'Invalid OTP entered'
         ]
      );
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


      return response()->json(
         [
            'message' =>
            'Password has been changed sucessfully',
            "User" => $user
         ]
      );
      // DB::table('password_resets')->where(['email'=> $request->email])->delete();

   }
}
