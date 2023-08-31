<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CrystalCustomer
{

    public static function addCustomer($request)
    {
        $validator = Self::validate($request);
        if ($validator->fails()) {
            return
                [
                "status" => 403,
                "message" =>
                "validation_error",
                "errors" => $validator->errors(),
            ];
        }
        $customer = CustomerCreation::createCustomer(
            $request,
            'crystal',
        );
        $response = Self::addCustomerToCrystal($request, $customer);
        info($response);
        if (isset($request->external_id)) {
            if ($response->ok()) {
                return [
                    "success" => true,
                    "status" => 200,
                    "message" => "Customer added successfully",
                    "response" => $response->body(),
                ];
            } else {
                return [
                    "success" => true,
                    "status" => 401,
                    "message" => "An error occurred while processing",
                    "response" => $response,
                ];
            }
        } else {
            return [
                "success" => true,
                "status" => 200,
                "message" => "customer created successfully",
            ];
        }
    }
    public static function addCustomerToCrystal($request, $customer)
    {
        $random = rand(10000000, 99999999);
        $data = [
            'code' => $random,
            'companyid' => 'Total Energies',
            'cust_type' => 2,
            'group_id' => 'Mobile Sales',
            'name' => $request->customer_name,
            'glaccount' => $random,
            'active' => 1,
            'tel' => $request->contact_person,
            'email' => $customer->email,
            'address' => $request->postal_code ?? 'MKO',
            'startdate' => now(),
            'bal' => 0,
            'rep' => 1,
            'creditlimit' => 1,
            'terms' => 4,
            'currency_id' => 2,
            'loccode' => 'W' . rand(1, 99),
            'region_id' => 2,
            'pinno' => 'A' . rand(10000000, 99999999),
        ];
        info("Sending for Cystal Customer");
        info(json_encode($data));
        DB::table('leads_targets')
            ->where('user_code', $request->user()->user_code)
            ->increment('AchievedLeadsTarget');
        $response = Http::withBody(json_encode($data), 'application/json')->post(env('CRYSTAL_BASE_URL') . '/apis/customers/createcustomer.php');
        info($response);
        if ($response->failed()) {
            return [
                "success" => true,
                "status" => 401,
                "message" => "An error occurred while processing",
                "response" => $response,
            ];
        }
        if ($response->ok()) {
            $customer = $customer->update([
                'soko_uuid' => Str::uuid(),
                'external_uuid' => $random,
            ]);
            info($customer);
        } else {
            $customer->delete();
            return [
                "success" => true,
                "status" => 401,
                "message" => "An error occurred while processing",
                "response" => $response,
            ];
        }
        return $response;
    }
    public static function validate($request)
    {
        $validator = Validator::make($request->all(), [
            "customer_name" => "required|unique:customers",
            "contact_person" => "required",
            "business_code" => "required",
            "created_by" => "required",
            "phone_number" => "required|unique:customers",
            "latitude" => "required",
            "longitude" => "required",
            "image" => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        return $validator;
    }
}
