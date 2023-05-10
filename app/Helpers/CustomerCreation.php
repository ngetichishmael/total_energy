<?php

namespace App\Helpers;

use App\Models\customers;
use App\Models\MKOCustomer;
use Illuminate\Support\Str;

class CustomerCreation
{
   public static function createCustomer($request, $source)
   {
      $image_path = $request->file('image')->store('image', 'public');
      $emailData = $request->email == null ? strtolower(str_replace(' ', '', $request->customer_name)) . '@totalenergies.com' : $request->email;
      $customer = customers::updateOrCreate(
         [
            'customer_name' => $request->customer_name,
            'contact_person' => $request->contact_person,
         ],
         [
            'source' => $source,
            'odoo_uuid' => $request->odoo_uuid ?? Str::uuid(),
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
            'customer_group' => $request->customer_group,
            'city' => $request->address,
            'postal_code' => $request->address,
            'province' => $request->address,
            'country' => $request->country ?? "Kenya",
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'manufacturer_number' => $request->manufacturer_number,
            'route' => $request->route,
            'route_code' => $request->route_code,
            'region' => $request->region,
            'subregion' => $request->subregion,
            'zone' => $request->zone,
            'unit' => $request->unit,
            'branch' => $request->branch,
            'created_by' => $request->user()->id,
            'business_code' => $request->business_code,
         ]
      );
      if (isset($request->external_id)) {
         MKOCustomer::whereId($request->external_id)->update([
            'merged' => 1
         ]);
      }
      return $customer;
   }
}
