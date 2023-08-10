<?php

namespace App\Helpers;

use App\Models\MKOCustomer as Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class MKOEditCustomer
{
    public static function EditCustomer($request)
    {
        $validator = self::validate($request);
        if ($validator->fails()) {
            return [
                "status" => 403,
                "message" => "validation_error",
                "errors" => $validator->errors(),
            ];
        }

        $customer = Customer::find($request->id);

        if (!$customer) {
            return [
                "status" => 404,
                "message" => "Customer not found",
            ];
        }
        $customerData = [
            "customer_name" => $request->input("customer_name", $customer->customer_name),
            "account" => $request->input("account", $customer->account),
            "address" => $request->input("address", $customer->address),
            "latitude" => $request->input("latitude", $customer->latitude),
            "longitude" => $request->input("longitude", $customer->longitude),
            "contact_person" => $request->input("contact_person", $customer->contact_person),
            "customer_group" => $request->input("customer_group", $customer->customer_group),
            "price_group" => $request->input("price_group", $customer->price_group),
            "route" => $request->input("route", $customer->route),
            "region_id" => $request->input("region_id", $customer->region_id),
            "unit_id" => $request->input("unit_id", $customer->unit_id),
            "approval" => $request->input("approval", $customer->approval),
            "status" => $request->input("status", $customer->status),
            "telephone" => $request->input("telephone", $customer->telephone),
            "manufacturer_number" => $request->input("manufacturer_number", $customer->manufacturer_number),
            "vat_number" => $request->input("vat_number", $customer->vat_number),
            "delivery_time" => $request->input("delivery_time", $customer->delivery_time),
            "city" => $request->input("city", $customer->city),
            "province" => $request->input("province", $customer->province),
            "postal_code" => $request->input("postal_code", $customer->postal_code),
            "country" => $request->input("country", $customer->country),
            "customer_secondary_group" => $request->input("customer_secondary_group", $customer->customer_secondary_group),
            "branch" => $request->input("branch", $customer->branch),
            "email" => $request->input("email", $customer->email),
            "phone_number" => $request->input("phone_number", $customer->phone_number),
            "business_code" => $request->user()->business_code ?? $customer->business_code,
            "created_by" => $request->user()->id ?? $customer->created_by,
        ];

        if ($customer->update($customerData)) {
            $response = self::EditOdooCustomer($request, $customer);
            if ($response->ok()) {
                return [
                    "success" => true,
                    "status" => 200,
                    "message" => "Customer edit was successful",
                    "response" => $response->body(),
                ];
            } else {
                return [
                    "success" => false,
                    "status" => 401,
                    "message" => "An error occurred while processing",
                    "response" => $response->json(),
                ];
            }
        } else {
            return [
                "status" => 500,
                "message" => "Failed to update customer data",
            ];
        }
    }

    public static function EditOdooCustomer($request, $customer)
    {
        // Odoo customer update logic.
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
            "latitude" => (float) $request->latitude ?? $customer->latitude,
            "longitude" => (float) $request->longitude ?? $customer->longitude,
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
                "subregion" => "",
                "zone" => "",
                "unit" => "",
                "branch" => "Nairobi",
                "business_code" => $request->user()->business_code ?? $customer->business_code,
            ],
        ];

        info("Sending for Odoo Customer");
        DB::table('leads_targets')
            ->where('user_code', $request->user()->user_code)
            ->increment('AchievedLeadsTarget');

        $response = Http::withBody(json_encode($data), 'application/json')->post(config('app.mko_base_url') . '/customer');

        if ($response->ok()) {
            $resultJson = $response->json();
            $result = $resultJson['result'];
            $odoo_uuid = $result['data']['odoo_uuid'];
            $soko_uuid = $result['data']['soko_uuid'];
            $customer->update([
                'soko_uuid' => $soko_uuid,
                'odoo_uuid' => $odoo_uuid,
            ]);
            info("Odoo Uuid: " . $odoo_uuid);
            info("Sokoflow Uuid: " . $soko_uuid);
            info($customer);
        } else {
            return [
                "success" => false,
                "status" => 401,
                "message" => "An error occurred while processing",
                "response" => $response->json(),
            ];
        }

        return $response;
    }

    public static function validate($request)
    {
        $validator = Validator::make($request->all(), [
            "customer_name" => "required",
            "contact_person" => "required",
            "business_code" => "required",
            "created_by" => "required",
            "phone_number" => "required",
            "latitude" => "required",
            "longitude" => "required",
            "image" => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        return $validator;
    }
}
