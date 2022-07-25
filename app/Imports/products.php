<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\products\product_information;
use App\Models\products\product_price;
use App\Models\products\product_inventory;
use Auth;
use Helper;
class products implements ToCollection,WithHeadingRow
{
	/**
 * @param Collection $collection
	*/
	public function collection(Collection $rows){
		foreach ($rows as $row){
			$product = new product_information;
			$product->sku_code = $row['sku'];
         $product->product_name = $row['description'];
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
			$product->businessID = Auth::user()->businessID;
			$product->created_by = Auth::user()->id;
			$product->save();

			//product price
			$product_price = new product_price;
			$product_price->productID = $product->id;
			$product_price->selling_price = $row['price'];
         $product_price->buying_price = $row['cost'];
         $product_price->tax_rate = $row['vat'];
         $product_price->default_price = 'Yes';
			$product_price->businessID = Auth::user()->businessID;
			$product_price->created_by = Auth::user()->id;
			$product_price->save();

			//product quantities
			$product_inventory = new product_inventory;
			$product_inventory->current_stock = 0;
			$product_inventory->productID = $product->id;
         $product_inventory->default_inventory = 'Yes';
         $product_inventory->expiration_date = $row['expiration'];
			$product_inventory->businessID = Auth::user()->businessID;
			$product_inventory->created_by = Auth::user()->id;
			$product_inventory->save();
      }
	}
}
