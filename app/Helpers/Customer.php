<?php

namespace App\Helpers;

use App\Models\Area;
use App\Models\customer\customers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class Customer
{

    public static function addCustomer($request)
    {
        // Check if the request has a valid image file
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Upload the file here
            $validator = Self::validate($request);
    
            if ($validator->fails()) {
                return [
                    "status" => 403,
                    "message" => "validation_error",
                    "errors" => $validator->errors(),
                ];
            }
    
            // Upload the image to the public/images directory and get the file name
            $imagePath = $request->file('image')->store('images', 'public');
            $imageName = basename($imagePath);
    
            $emailData = $request->email == null ? strtolower(str_replace(' ', '', $request->customer_name)) . '@totalenergies.com' : $request->email;
    
            $area = Area::whereId($request->route_code)->firstOrFail();
            $subregion = $area->subregion_id ?? 1;
            $region = $subregion->region_id ?? 1;
    
            info('area :' . json_encode($area->id));
            info('subregion :' . json_encode($subregion));
            info('region :' . json_encode($region));
    
            $customer = customers::updateOrCreate(
                [
                    'customer_name' => $request->customer_name,
                    'contact_person' => $request->contact_person,
                ],
                [
                    'source' => "Sokoflow",
                    'soko_uuid' => $request->odoo_uuid ?? Str::uuid(),
                    'external_uuid' => $request->external_id ?? Str::uuid(),
                    'customer_secondary_group' => $request->company_type ?? $request->outlet,
                    'image' => $imageName, // Store the image name in the 'image' column
                    'telephone' => $request->phone_number,
                    'phone_number' => $request->phone_number,
                    'account' => $request->customer_name,
                    'email' => $emailData,
                    'address' => $request->address,
                    'customer_group' => $request->outlet,
                    'city' => $request->address,
                    'postal_code' => $request->address,
                    'price_group' => "Price Group 1",
                    'province' => $request->address,
                    'country' => $request->country ?? "Kenya",
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'manufacturer_number' => $request->manufacturer_number,
                    'route' => $request->route_code,
                    'route_code' => $request->route_code,
                    'subregion_id' => $subregion,
                    'region_id' => $region,
                    'zone_id' => $request->route_code,
                    'unit_id' => $request->route_code,
                    'branch' => $request->branch,
                    'status' => "Active",
                    'delivery_time' => now(),
                    'created_by' => $request->user()->id,
                    'updated_by' => $request->user()->id,
                    'approval' => ($request->outlet === "Wholesalers" ? (
                        in_array($request->route_code, [1, 5, 6, 7, 9, 10, 11]) ?
                        "Not Approved" : "Approved") : "Approved"),
                    'business_code' => $request->business_code,
                ]
            );
    
            DB::table('leads_targets')
                ->where('user_code', $request->user()->user_code)
                ->increment('AchievedLeadsTarget');
    
            return [
                "success" => true,
                "status" => 200,
                "message" => "Customer added successfully",
                'customer' => $customer,
            ];
        } else {
            // Handle file upload error
            return [
                "status" => 400,
                "message" => "Invalid file upload",
            ];
        }
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
