<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\finance\suppliers\suppliers as supplier;
use App\Models\finance\suppliers\supplier_address;
use Helper;
use Auth;

class suppliers implements ToCollection,WithHeadingRow
{
   /**
   * @param Collection $collection
   */
   public function collection(Collection $rows){
      foreach ($rows as $row){
         $primary = new supplier;
   		$code = Helper::generateRandomString(10);
   		$primary->supplierName = $row['name'];
   		$primary->referenceNumber = Helper::generateRandomString(10);
   		$primary->email = $row['email'];
    		$primary->primaryPhoneNumber = $row['phonenumber'];
   		$primary->supplierCode = $code; 
			$primary->website = $row['website'];
         $primary->created_by = Auth::user()->id;
         $primary->updated_by = Auth::user()->id;
			$primary->businessID = Auth::user()->businessID;
    		$primary->save();

    		//address
    		$address = new supplier_address;
   		$address->supplierID = $primary->id;
   		$address->bill_attention = $row['name'];
         $address->bill_street = $row['street'];
         $address->bill_state = $row['state'];
    		$address->bill_city = $row['city'];
    		$address->bill_zip_code = $row['zipcode'];
    		$address->bill_country = 110;
			$address->bill_postal_address = $row['postaladdress'];
    		$address->save();
      }
   }
}
