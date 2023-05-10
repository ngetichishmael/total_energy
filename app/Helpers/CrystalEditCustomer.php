<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\MKOCustomer as Customer;

use Illuminate\Support\Facades\Validator;

class CrystalEditCustomer
{

   public static function  addCustomer($request)
   {
      $validator = Self::validate($request);
      if ($validator->fails()) {
         return
            [
               "status" => 403,
               "message" =>
               "validation_error",
               "errors" => $validator->errors()
            ];
      }
      $image_path = $request->file('image')->store('image', 'public');
      $customer = Customer::updateOrCreate(
         [
            'customer_name' => $request->customer_name,
            'contact_person' => $request->contact_person,
         ],
         [
            'odoo_uuid' => $request->odoo_uuid,
            'soko_uuid' => $request->soko_uuid,
            'company_type' => $request->company_type,
            'image' => $image_path,
            'telephone' => $request->phone_number,
            'phone_number' => $request->phone_number,
            'mobile' => $request->mobile,
            'email' => $image_path,
            'type' => $request->type,
            'street' => $request->street,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'manufacturer_number' => $request->manufacturer_number,
            'route' => $request->route,
            'route_code' => "Nairobi",
            'region' => "",
            'subregion' => "",
            'zone' => "",
            'unit' => "",
            'branch' => $request->branch,
            'business_code' => $request->business_code,
         ]
      );
      $response = Self::addCustomerToOdoo($request, $customer);
      if ($response->ok()) {
         return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Customer added successfully",
            "response" => $response->body()
         ]);
      } else {
         return response()->json([
            "success" => true,
            "status" => 401,
            "message" => "An error occurred while processing",
            "response" => $response
         ]);
      }
   }
   public static function addCustomerToOdoo($request, $customer)
   {
      $data = [
         "id" => $customer->id,
         "soko_uuid" => Str::uuid(),
         "company_type" => "",
         "image" => base64_encode(file_get_contents($request->file('image')->pat‌​h())),
         "customer_name" => $request->customer_name ?? $customer->customer_name,
         "telephone" => $request->telephone ?? $customer->telephone,
         "mobile" => $request->telephone ?? $customer->telephone,
         "email" => $request->email ?? $customer->email,
         "type" => "",
         "contact_person" => $request->contact_person ?? $customer->contact_person,
         "latitude" => $request->latitude ?? $customer->latitude,
         "longitude" => $request->longitude ?? $customer->longitude,
         "address" => [
            "street" => $request->address ?? $customer->address,
            "city" => $request->address ?? $customer->address,
            "postal_code" => $request->address ?? $customer->address,
            "country" => $request->address ?? $customer->address,
         ],
         "metadata" => [
            "manufacturer_number" => $request->manufacturer_number ?? $customer->manufacturer_number,
            "route" => $request->route ?? $customer->route,
            "route_code" => "Nairobi",
            "region" =>  "Nairobi",
            "subregion" =>  "",
            "zone" =>  "",
            "unit" =>  "",
            "branch" => $request->branch ?? $customer->branch,
            "business_code" => $request->user()->business_code ?? $customer->business_code
         ]
      ];

      info("Sending for Odoo Customer");
      info($data);
      DB::table('leads_targets')
         ->where('user_code', $request->user()->user_code)
         ->increment('AchievedLeadsTarget');
      $response = Http::withHeaders([
         "Content-Type" => "application/json",
      ])->post(env("BASE_URL"), $data);
      return $response;
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
   }
}
