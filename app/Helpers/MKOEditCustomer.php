<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\MKOCustomer as Customer;
use Illuminate\Support\Facades\Validator;

class MKOEditCustomer
{

   public static function  EditCustomer($request)
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
      $customer = Customer::whereId($request->id)->first();
      $customerData = [];
      if (isset($customer)) {
         $customerData = Customer::create(
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
      } else {
         $customerData = Customer::whereId($request->id)->update(
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
      }

      $response = Self::EditOdooCustomer($request, $customerData);
      if ($response->ok()) {
         return [
            "success" => true,
            "status" => 200,
            "message" => "Customer edit was successfully",
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
   public static function EditOdooCustomer($request, $customer)
   {
      $data = [
         "id" => $customer->id,
         "soko_uuid" => $customer->soko_uuid,
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
      DB::table('leads_targets')
         ->where('user_code', $request->user()->user_code)
         ->increment('AchievedLeadsTarget');
      $response = Http::withBody(json_encode($data), 'application/json')->post(env('MKO_BASE_URL') . '/customer');
      if ($response->ok()) {
         $resultJson = $response->json();
         $result = $resultJson['result'];
         $odoo_uuid = $result['data']['odoo_uuid'];
         $soko_uuid = $result['data']['soko_uuid'];
         $customer = $customer->update([
            'soko_uuid' => $soko_uuid,
            'odoo_uuid' => $odoo_uuid
         ]);
         info("Odoo Uuid: " . $odoo_uuid);
         info("Sokoflow Uuid: " . $soko_uuid);
         info($customer);
      } else {
         return [
            "success" => true,
            "status" => 401,
            "message" => "An error occurred while processing",
            "response" => $response
         ];
      }
      return $response;
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
