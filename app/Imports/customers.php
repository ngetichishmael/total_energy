<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\customer\customers as customer;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class customers implements ToCollection, WithHeadingRow
{
   /**
    * @param Collection $collection
    */
   public function collection(Collection $rows)
   {
      foreach ($rows as $row) {
         $customer = new customer;
         $customer->customer_name = $row['customer_name'];
         $customer->account = $row['account'];
         $customer->address = $row['address'];
         $customer->latitude = $row['latitude'];
         $customer->longitude = $row['longitude'];
         $customer->contact_person = $row['contact_person'] . $row['contact_person_2'];
         $customer->customer_group = $row['customer_group'];
         $customer->price_group = $row['price_group'];
         $customer->route = $row['route'];
         $customer->approval = 'Approved';
         $customer->status = 'Active';
         //$customer->telephone = $row['telephone'];
         //$customer->manufacturer_number = $row['manufacturer_number'];
         // $customer->vat_number = $row['vat_number'];
         // $customer->delivery_time = $row['delivery_time'];
         // $customer->city = $row['city'];
         // $customer->province = $row['province'];
         // $customer->postal_code = $row['postal_code'];
         // $customer->country = $row['country'];
         // $customer->customer_secondary_group = $row['customer_secondary_group'];
         // $customer->branch = $row['branch'];
         // $customer->email = $row['email'];
         // $customer->phone_number = $row['phone_number'];
         $customer->businessID = Auth::user()->business_code;
         $customer->created_by = Auth::user()->id;
         $customer->save();
      }
   }
}