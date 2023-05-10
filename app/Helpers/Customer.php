<?php

namespace App\Helpers;

use App\Models\customer\customers;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

class Customer
{

   public static function addCustomer($request)
   {
      $validator = Self::validate($request);
      if ($validator->fails()) {
         return
            [
               "status" => 401,
               "message" =>
               "validation_error",
               "errors" => $validator->errors()
            ];
      }
      $image_path = $request->file('image')->store('image', 'public');
      $emailData = $request->email == null ? null : $request->email;
      $customer = customers::create([
         'customer_name' => $request->customer_name,
         'contact_person' => $request->contact_person,
         'phone_number' => $request->phone_number,
         'email' => $emailData,
         'address' => $request->address,
         'latitude' => $request->latitude,
         'longitude' => $request->longitude,
         'business_code' => $request->business_code,
         'created_by' => $request->user()->user_code,
         'route_code' => $request->route_code,
         'customer_group' => $request->outlet,
         'region_id' => $request->route_code,
         'unit_id' => $request->route_code,
         'image' => $image_path,
      ]);
      DB::table('leads_targets')
         ->where('user_code', $request->user()->user_code)
         ->increment('AchievedLeadsTarget');
      return [
         "success" => true,
         "status" => 200,
         "message" => "Customer added successfully",
         'customer' => $customer
      ];
   }
   public static function validate($request)
   {
      $validator           =  Validator::make($request->all(), [
         "customer_name"   => "required|unique:customers",
         "contact_person"  => "required",
         "business_code"   => "required",
         "created_by"      => "required",
         "phone_number"    => "required|unique:customers",
         "latitude"        => "required",
         "longitude"       => "required",
         "image" => 'required|image|mimes:jpg,png,jpeg,gif,svg',
      ]);

      return $validator;
   }
}
