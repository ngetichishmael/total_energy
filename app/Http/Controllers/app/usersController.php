<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Session;

use Illuminate\Support\Str;
use App\Http\Controllers\Api\JWTException;
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
   public function sendOTP($number,$code) {

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
            CURLOPT_POSTFIELDS =>'{
                "number" : "'.$number.'",
                "sms" : '.$code.',
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
      } catch (JWTException $e) {

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
      $passwordcode =Str::random(7);
      //save user
      $user = new User;
      $user->user_code =Str::random(20);
      $user->email = $request->email;
      $user->phone_number = $request->phone_number;
      $user->name = $request->name;
      $user->account_type = $request->account_type;
      $user->status = 'Active';
      $user->password = Hash::make($passwordcode);
      $user->business_code = FacadesAuth::user()->business_code;
      $user->save();
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
           CURLOPT_POSTFIELDS =>'{
               "number" : "0724840014",
               "sms" : '.$passwordcode.',
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
         dd($response);

         curl_close($curl);
     } catch (JWTException $e) {

     }
      Session::flash('success', 'User Created Successfully');
      // Redirect::back()->with('message', 'User Created Successfully');

      return redirect()->route('users.index');
   }

   //edit
   public function edit($id)
   {
      $edit = User::where('id', $id)->where('business_code', FacadesAuth::user()->business_code)->first();

      return view('app.users.edit', compact('edit'));
   }

   //update
   public function update(Request $request, $id)
   {
      $this->validate($request, [
         'email' => 'required',
         'name' => 'required',
         'phone_number' => 'required',
         'account_type' => 'required',
      ]);

      //save user
      $edit = User::where('id', $id)->where('business_code', FacadesAuth::user()->business_code)->first();
      $edit->email = $request->email;
      $edit->phone_number = $request->phone_number;
      $edit->name = $request->name;
      $edit->account_type = $request->account_type;
      $edit->status = $request->status;
      $edit->password = Hash::make($request->phone_number);
      $edit->admin_id = FacadesAuth::user()->id;
      $edit->save();

      Session::flash('success', 'User updated Successfully');

      return redirect()->back();
   }
   public function destroy($id)
   {
      User::where('id', $id)->delete();
      Session::flash('success', 'User deleted Successfully');
      return redirect()->route('users.index');
   }
}
