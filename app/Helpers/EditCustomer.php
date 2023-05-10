<?php

namespace App\Helpers;

use App\Models\customer\customers;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

class EditCustomer
{

   public static function EditCustomer($request)
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
      $customer = customers::whereId($request->id)->first();
      $customer = customers::whereId($request->id)->update(
         [
            "customer_name" => $request->customer_name ?? $customer->customer_name,
            "account" => $request->account ?? $customer->account,
            "address" => $request->address ?? $customer->address,
            "latitude" => $request->latitude ?? $customer->latitude,
            "longitude" => $request->longitude ?? $customer->longitude,
            "contact_person" => $request->contact_person ?? $customer->contact_person,
            "customer_group" => $request->customer_group ?? $customer->customer_group,
            "price_group" => $request->price_group ?? $customer->price_group,
            "route" => $request->route ?? $customer->route,
            "region_id" => $request->route ?? $customer->route,
            "unit_id" => $request->route ?? $customer->route,
            "approval" => 'Approved' ?? $customer->approval,
            "status" => 'Active' ?? $customer->status,
            "telephone" => $request->telephone ?? $customer->telephone,
            "manufacturer_number" => $request->manufacturer_number ?? $customer->manufacturer_number,
            "vat_number" => $request->vat_number ?? $customer->vat_number,
            "delivery_time" => $request->delivery_time ?? $customer->delivery_time,
            "city" => $request->city ?? $customer->city,
            "province" => $request->province ?? $customer->province,
            "postal_code" => $request->postal_code ?? $customer->postal_code,
            "country" => $request->country ?? $customer->country,
            "customer_secondary_group" => $request->customer_secondary_group ?? $customer->customer_secondary_group,
            "branch" => $request->branch ?? $customer->branch,
            "email" => $request->email ?? $customer->email,
            "phone_number" => $request->phone_number ?? $customer->phone_number,
            "business_code" => $request->user()->business_code ?? $customer->business_code,
            "created_by" => $request->user()->id ?? $customer->id
         ]
      );
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
         "customer_name"   => "required",
         "contact_person"  => "required",
         "business_code"   => "required",
         "created_by"      => "required",
         "phone_number"    => "required",
         "latitude"        => "required",
         "longitude"       => "required",
         "image" => 'required|image|mimes:jpg,png,jpeg,gif,svg',
      ]);

      return $validator;
   }
}
