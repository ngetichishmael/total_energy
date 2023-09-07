<?php

namespace App\Helpers;

use App\Models\Area;
use App\Models\customers;
use App\Models\MKOCustomer;
use Illuminate\Support\Str;

class CustomerCreation
{
    public static function createCustomer($request, $source)
    {
        $image_path = $request->file('image')->store('image', 'public');
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
                'source' => $source,
                'soko_uuid' => $request->odoo_uuid ?? Str::uuid(),
                'external_uuid' => $request->external_id ?? Str::uuid(),
                'company_type' => $request->company_type,
                'image' => $image_path,
                'telephone' => $request->phone_number,
                'mobile' => $request->phone_number,
                'phone_number' => $request->phone_number,
                'email' => $emailData,
                'type' => $request->type,
                'street' => $request->address,
                'address' => $request->address,
                'customer_group' => $request->outlet,
                'city' => $request->address,
                'postal_code' => $request->address,
                'province' => $request->address,
                'country' => $request->country ?? "Kenya",
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'manufacturer_number' => $request->manufacturer_number,
                'route' => $request->route_code,
                'route_code' => $request->route_code,
                'region_id' => $subregion,
                'subregion_id' => $region,
                'zone_id' => $request->route_code,
                'unit_id' => $request->route_code,
                'branch' => $request->branch,
                'created_by' => $request->user()->id,
                'approval' => ($request->outlet === "Wholesalers" ? (
                    in_array($request->route_code, [1, 5, 6, 7, 9, 10, 11]) ?
                    "Not Approved" : "Approved") : "Approved"),
                'business_code' => $request->business_code,
            ]
        );
        if (isset($request->external_id)) {
            MKOCustomer::whereId($request->external_id)->update([
                'merged' => 1,
            ]);
        }
        return $customer;
    }
}
