<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\products\product_price;
use App\Models\products\product_inventory;
use App\Models\products\product_information;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class products implements ToCollection, WithHeadingRow
{
   /**
    * @param Collection $collection
    */
   public function collection(Collection $rows)
   {
      foreach ($rows as $row) {
         $product = new product_information;
         $product->sku_code = $row['sku'];
         $product->product_name = $row['product_name'];
         $product->description = $row['description'];
         $product->manufacture_code = $row['manufacture'];
         $product->brand = $row['brand'];
         $product->category = $row['category'];
         $product->units = $row['units'];
         $product->measure = $row['measure'];
         $product->weight = $row['weight'];
         $product->orderable = $row['orderable'];
         $product->returnable = $row['returnable'];
         $product->returnable_on_pre_sale_delivery = $row['returnable_on_pre_sale_delivery'];
         $product->exclude_on_van_sale = $row['van_sale'];
         $product->status = $row['status'];
         $product->batch_code = $row['batch'];
         $product->barcode = $row['barcode'];
         $product->business_code = Auth::user()->business_code;
         $product->created_by = Auth::user()->id;
         $product->save();

         //product price
         $product_price = new product_price;
         $product_price->productID = $product->id;
         $product_price->selling_price = $row['price'] ?? "0";
         $product_price->buying_price = $row['cost'] ?? "0";
         $product_price->tax_rate = $row['vat'];
         $product_price->default_price = 'Yes';
         $product_price->business_code = Auth::user()->business_code;
         $product_price->created_by = Auth::user()->id;
         $product_price->save();

         //product quantities
         $product_inventory = new product_inventory;
         $product_inventory->current_stock = 0;
         $product_inventory->productID = $product->id;
         $product_inventory->default_inventory = 'Yes';
         $product_inventory->expiration_date = $row['expiration'] ?? today();
         $product_inventory->business_code = Auth::user()->business_code;
         $product_inventory->created_by = Auth::user()->id;
         $product_inventory->save();
      }
   }
}