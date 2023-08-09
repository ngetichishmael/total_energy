<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\products\product_information;
use App\Models\Region;
use App\Models\warehousing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
         'product_price.buying_price as wholesale_price',
         'product_price.selling_price as retail_price',
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
   public function index3(Request $request, $businessCode)
   {
      $route_code = $request->user()->route_code;
      $region_id = $request->user()->region_id;
      $region = Region::whereId($region_id)->first();
      if ($region){
         $warehouses = warehousing::where('region_id', $region->id)->select('warehouse_code')->distinct('warehouse_code')->get();
         $products = product_information::whereIn('warehouse_code', [$warehouses])->join('product_inventory', 'product_inventory.productID', '=', 'product_information.id')
            ->join('product_price', 'product_price.productID', '=', 'product_information.id')
            ->select(
               'product_price.branch_id as region',
               'product_information.id as productID',
               'product_information.created_at as date',
               'product_price.buying_price as wholesale_price',
               'product_price.selling_price as retail_price',
               'product_price.distributor_price as distributor_price',
               'product_information.product_name as product_name',
               'product_inventory.current_stock as stock',
               'product_information.created_at as date',
               'product_information.business_code as business_code',
               'sku_code',
               'brand',
               'category',
               'warehouse_code'
            )
            ->get();
      }
      else
      {
         $products = product_information::join('product_inventory', 'product_inventory.productID', '=', 'product_information.id')
            ->join('product_price', 'product_price.productID', '=', 'product_information.id')
            ->select(
               'product_price.branch_id as region',
               'product_information.id as productID',
               'product_information.created_at as date',
               'product_price.buying_price as wholesale_price',
               'product_price.selling_price as retail_price',
               'product_price.distributor_price as distributor_price',
               'product_information.product_name as product_name',
               'product_inventory.current_stock as stock',
               'product_information.created_at as date',
               'product_information.business_code as business_code',
               'sku_code',
               'brand',
               'category',
               'warehouse_code'
            )
            ->get();
      }
      return response()->json([
         "success" => true,
         "message" => "All Regional Warehouses Product List",
         "data" => $products,
      ]);
   }
   public function index2(Request $request, $warehouseCode)
   {
      $route_code = $request->user()->route_code;
      $region_id = Region::whereId($route_code)->first();
      $products = product_information::where("warehouse_code", $warehouseCode)->join('product_inventory', 'product_inventory.productID', '=', 'product_information.id')
         ->join('product_price', 'product_price.productID', '=', 'product_information.id')
         ->select(
            'product_price.branch_id as region',
            'product_information.id as productID',
            'product_information.created_at as date',
//            'product_price.buying_price as wholesale_price',
//            'product_price.selling_price as retail_price',
            DB::raw('CAST(product_price.buying_price AS CHAR) as wholesale_price'),
            DB::raw('CAST(product_price.selling_price AS CHAR) as retail_price'),
            'product_price.distributor_price as distributor_price',
            'product_information.product_name as product_name',
            'product_inventory.current_stock as stock',
            'product_information.created_at as date',
            'product_information.business_code as business_code',
            'sku_code',
            'brand',
            'category',
            'warehouse_code'
         )
         ->get();

      return response()->json([
         "success" => true,
         "message" => "Product List",
         "data" => $products
      ]);
   }
}
