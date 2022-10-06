<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReconciledProducts as ReconciledProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReconciledProductsController extends Controller
{
   public function index(Request $request)
   {
      $usercode = $request->user()->user_code;
      $id = $request->user()->id;
      $request = $request->all();
      array_pop($request);
      info($request);
      foreach ($request as $data) {
         $reconciled_products = new ReconciledProducts();
         $reconciled_products->productID = $data['productID'];
         $reconciled_products->amount = $data['amount'];
         $reconciled_products->supplierID = $data['supplierID'];
         $reconciled_products->userCode  = $usercode;
         $reconciled_products->save();
         DB::update('UPDATE
            `inventory_allocated_items`
                    SET
                        `current_qty` =`current_qty`-?,
                        `allocated_qty` =`allocated_qty`-?,
                        `returned_qty` = ?,
                        `updated_at` = CURRENT_DATE
                    WHERE
                    `inventory_allocated_items`.`created_by`=?', [$data['amount'], $data['amount'], $data['amount'], $usercode]);

         DB::update('UPDATE
            `product_inventory`
                    SET
                        `current_stock` =`current_stock`-?,
                        `updated_by`=?,
                        `updated_at` = CURRENT_DATE
                    WHERE
                    `product_inventory`.`productID`=?', [$data['amount'], $id, $data['productID']]);
                    
      }

      return response()->json([
         "success" => true,
         "message" => "All products were successfully reconciled",
         "Result"    => "Successful"
      ]);
   }
}
