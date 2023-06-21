<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\products\product_information;
use App\Models\Region;
use Illuminate\Http\Request;

/**
 * @group Product
 *
 * APIs to manage the products
 * */
class productsController extends Controller
{
   /**
    * Product list
    *
    * @param $businessCode
    **/
   public function index(Request $request, $businessCode)
   {
      $route_code = $request->user()->route_code;
      $region_id = Region::whereId($route_code)->first();
      $query = product_information::join('product_inventory', 'product_inventory.productID', '=', 'product_information.id')
         ->join('product_price', 'product_price.productID', '=', 'product_information.id');
      if ($region_id->id == 12) {
         $query->where('product_price.branch_id', $region_id->id);
      }
      $products = $query->select(
         'product_price.branch_id as region',
         'product_information.id as productID',
         'product_information.created_at as date',
         'product_price.selling_price as wholesale_price',
         'product_price.buying_price as retail_price',
         'product_information.product_name as product_name',
         'product_inventory.current_stock as stock',
         'product_information.created_at as date',
         'product_information.business_code as business_code',
         'sku_code',
         'brand',
         'category'
      )
         ->get();

      return response()->json([
         "success" => true,
         "message" => "Product List",
         "data" => $products
      ]);
   }
}
