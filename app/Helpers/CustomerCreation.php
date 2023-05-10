<?php

namespace App\Helpers;

use App\Models\customers;
use Illuminate\Support\Str;

class CustomerCreation
{
   public static function createCustomer($request, $source)
   {
      $image_path = $request->file('image')->store('image', 'public');
      $emailData = $request->email == null ? null : $request->email;
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
            'telephone' => $request->telephone,
            'mobile' => $request->mobile,
            'email' => $emailData,
            'type' => $request->type,
            'street' => $request->street,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
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
            'business_code' => $request->business_code,
         ]
      );
      return $customer;
   }
}
