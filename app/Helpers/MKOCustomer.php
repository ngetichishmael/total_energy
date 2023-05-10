<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class MKOCustomer
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
      $customer = CustomerCreation::createCustomer($request, 'odoo');
      $response = Self::addCustomerToOdoo($request, $customer);
      if ($response->ok()) {
         return [
            "success" => true,
            "status" => 200,
            "message" => "Customer added successfully",
            "response" => $response->body()
         ];
      } else {
         return [
            "success" => true,
            "status" => 401,
            "message" => "An error occurred while processing",
            "response" => $response
         ];
      }
   }
   public static function addCustomerToOdoo($request, $customer)
   {
      $data = [
         "id" => $customer->id,
         "soko_uuid" => Str::uuid(),
         "company_type" => "",
         "image" => base64_encode(file_get_contents($request->file('image'))),
         "customer_name" => $request->customer_name,
         "telephone" => $request->phone_number ?? $customer->phone_number,
         "phone_number" => $request->phone_number ?? $customer->phone_number,
         "mobile" => $request->phone_number ?? $customer->phone_number,
         "email" => $request->email ?? $customer->email,
         "type" => "",
         "contact_person" => $request->contact_person ?? $customer->contact_person,
         "latitude" => (float)$request->latitude ?? $customer->latitude,
         "longitude" => (float)$request->longitude ?? $customer->longitude,
         "address" => [
            "street" => $request->address ?? $customer->address,
            "city" => $request->address ?? $customer->address,
            "postal_code" => $request->address ?? $customer->address,
            "country" => $request->address ?? $customer->address,
         ],
         "metadata" => [
            "manufacturer_number" => "Nairobi",
            "route" => "nairobi",
            "route_code" => "Nairobi",
            "region" => "",
            "subregion" =>  "",
            "zone" =>  "",
            "unit" =>  "",
            "branch" => "Nairobi",
            "business_code" => $request->user()->business_code ?? $customer->business_code
         ]
      ];

      info("Sending for Odoo Customer");
      info(json_encode($data));
      DB::table('leads_targets')
         ->where('user_code', $request->user()->user_code)
         ->increment('AchievedLeadsTarget');
      $response = Http::withBody(json_encode($data), 'application/json')->post(env('MKO_CUSTOMER'));

      if ($response->ok()) {
         $resultJson = $response->json();

         if (isset($resultJson['result'])) {
            $result = $resultJson['result'];

            if (isset($result['data']['odoo_uuid'], $result['data']['soko_uuid'])) {
               $odoo_uuid = $result['data']['odoo_uuid'];
               $soko_uuid = $result['data']['soko_uuid'];

               $customer->update([
                  'soko_uuid' => $soko_uuid,
                  'odoo_uuid' => $odoo_uuid
               ]);

               info("Odoo Uuid: " . $odoo_uuid);
               info("Sokoflow Uuid: " . $soko_uuid);
            }
         } else {
            $customer->delete();
            $response = [
               "success" => true,
               "status" => 401,
               "message" => "An error occurred while processing",
               "response" => $response
            ];
            return $response;
         }
      } else {
         $response = [
            "success" => true,
            "status" => 401,
            "message" => "An error occurred while processing",
            "response" => $response
         ];
         return $response;
      }

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
      return $validator;
   }
}
