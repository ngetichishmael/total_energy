<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Session;

use Illuminate\Support\Str;
use App\Http\Controllers\Api\JWTException;
use App\Models\AppPermission;
use Exception;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Redirect;

class usersController extends Controller
{
   //list
   public function index()
   {
      return view('app.users.index');
   }

   //create
   public function create()
   {
      return view('app.users.create');
   }
   public function sendOTP($number, $code)
   {

      try {
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
      } catch (Exception $e) {
      }
   }

   //store
   public function store(Request $request)
   {
      $this->validate($request, [
         'email' => 'required',
         'name' => 'required',
         'phone_number' => 'required',
         'account_type' => 'required',
      ]);
      $user_code = Str::random(20);
      //save user
      $code = rand(100000, 999999);
      User::updateOrCreate(
         [
            "user_code" => $user_code,

         ],
         [
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "name" => $request->name,
            "account_type" => $request->account_type,
            "status" => 'Active',
            "password" => Hash::make($code),
            "business_code" => FacadesAuth::user()->business_code,

         ]
      );
      $van_sales = $request->van_sales == null ? "NO" : "YES";
      $new_sales = $request->new_sales == null ? "NO" : "YES";
      $deliveries = $request->deliveries == null ? "NO" : "YES";
      $schedule_visits = $request->schedule_visits == null ? "NO" : "YES";
      $merchanizing = $request->merchanizing == null ? "NO" : "YES";
      AppPermission::updateOrCreate(
         [
            "user_code" => $user_code,

         ],
         [
            "van_sales" => $van_sales,
            "new_sales" => $new_sales,
            "schedule_visits" => $schedule_visits,
            "deliveries" => $deliveries,
            "merchanizing" => $merchanizing,
         ]
      );
      try {
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
               "number" :  "' . $request->phone_number . '",
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
      } catch (Exception $e) {
      }
      Session()->flash('success', 'User Created Successfully');
      // Redirect::back()->with('message', 'User Created Successfully');

      return redirect()->route('users.index');
   }

   //edit
   public function edit($user_code)
   {
      $edit = User::where('user_code', $user_code)
         ->where('business_code', FacadesAuth::user()->business_code)
         ->first();
      $permissions = AppPermission::where('user_code', $user_code)->firstOrFail();

      return view('app.users.edit', [
         'edit' => $edit,
         'user_code' => $user_code,
         'permissions' => $permissions
      ]);
   }

   //update
   public function update(Request $request, $user_code)
   {
      $this->validate($request, [
         'email' => 'required',
         'name' => 'required',
         'phone_number' => 'required',
         'account_type' => 'required',
      ]);

      User::updateOrCreate(
         [
            "user_code" => $user_code,
            "business_code" => FacadesAuth::user()->business_code,
         ],
         [
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "name" => $request->name,
            "account_type" => $request->account_type,
            "status" => 'Active',

         ]
      );
      $van_sales = $request->van_sales == null ? "NO" : "YES";
      $new_sales = $request->new_sales == null ? "NO" : "YES";
      $deliveries = $request->deliveries == null ? "NO" : "YES";
      $schedule_visits = $request->schedule_visits == null ? "NO" : "YES";
      $merchanizing = $request->merchanizing == null ? "NO" : "YES";
      AppPermission::updateOrCreate(
         [
            "user_code" => $user_code,
         ],
         [
            "van_sales" => $van_sales,
            "new_sales" => $new_sales,
            "schedule_visits" => $schedule_visits,
            "deliveries" => $deliveries,
            "merchanizing" => $merchanizing,
         ]
      );

      Session()->flash('success', 'User updated Successfully');

      return redirect()->back();
   }
   public function destroy($id)
   {
      User::where('id', $id)->delete();
      Session()->flash('success', 'User deleted Successfully');
      return redirect()->route('users.index');
   }
}
