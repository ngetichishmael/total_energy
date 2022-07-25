<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\products\product_information;
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
   public function index($businessCode){
      $products = product_information::join('product_inventory','product_inventory.productID','=','product_information.id')
                                    ->join('product_price','product_price.productID','=','product_information.id')
                                    ->whereNull('parentID')
                                    ->where('default_inventory','Yes')
                                    ->where('default_price','Yes')
                                    ->where('product_information.business_code', $businessCode)
                                    ->select('product_information.id as productID','product_information.created_at as date','product_price.selling_price as price','product_information.product_name as product_name','product_inventory.current_stock as stock','product_information.created_at as date','product_information.business_code as business_code','sku_code','brand','category')
                                    ->get();

      return response()->json([
         "success" => true,
         "message" => "Product List",
         "data" => $products
      ]);
   }
}
