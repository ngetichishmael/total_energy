<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\inventory\allocations;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class StockLiftController extends Controller
{
    public function index(Request $request)
    {
        $user_code = $request->user()->user_code;
        $business_code = $request->user()->business_code;
        $random = Str::random(20);
        $request = $request->collect();
        foreach ($request as $value) {
            $stock = DB::select('SELECT `product_code`  FROM `inventory_allocated_items` WHERE `product_code` =? AND `created_by`= ?', [$value["productID"], $user_code]);
            if ($stock == null) {
                DB::insert(
                    'INSERT INTO `inventory_allocated_items`(
                `business_code`,
                `allocation_code`,
                `product_code`,
                `current_qty`,
                `allocated_qty`,
                `returned_qty`,
                `created_by`,
                `updated_by`,
                `created_at`,
                `updated_at`
            )
            VALUES(
                ?,?,?,
                (SELECT `current_stock` FROM `product_inventory` WHERE `productID` = ?),
                ?,?,?,?,?,?);',
                    [
                        $business_code,
                        $random,
                        $value["productID"],
                        $value["productID"],
                        $value["qty"],
                        0,
                        $user_code,
                        $user_code,
                        now(),
                        now()
                    ]
                    );
            } else {

               DB::table('inventory_allocated_items')
               ->where('product_code',$value["productID"])
               ->increment('allocated_qty',$value["qty"]);
            }
            $stock =null;
            DB::table('product_inventory')
            ->where('productID',$value["productID"])
            ->decrement('current_stock',$value["qty"]);


        }
        allocations::created([
         "business_code"=>$business_code,
         "allocation_code"=>$random,
         "sales_person"=>$user_code,
         "status"=>"Waiting acceptance",
         "created_by"=>$user_code,
         "created_by"=>$user_code,

        ]);
        return response()->json([
            "success" => true,
            "message" => "All Available Product Information",
            "Result"    => "Successful"
        ]);
    }
    public function show(Request $request)
    {
        $businessCode = $request->user()->business_code;
        $supplierID= $request->supplierID;
        $query = DB::select('SELECT
        `product_information`.`supplierID` as `SupplierID`,
        `product_information`.`business_code` as `business_code`,
        `product_information`.`sku_code`,
        `product_information`.`brand`,
        `product_information`.`category`,
        `product_information`.`id` AS `productID`,
        `product_information`.`created_at` as `date`,
        `product_information`.`product_name` as `product_name`,
        `product_price`.`selling_price` as `price`,
        `product_inventory`.`current_stock` AS `current stock`
            FROM
                `product_information`
            INNER JOIN `product_inventory` ON `product_inventory`.`business_code` = `product_information`.`business_code`
            INNER JOIN `product_price` ON `product_price`.`productID` = `product_information`.`id`
            WHERE
                `product_information`.`business_code` = ? AND `product_information`.`supplierID` = ?
            GROUP BY `productID`', [$businessCode,$supplierID]);

        return response()->json([
            "success" => true,
            "message" => "All Available Product Information filtered by Distributers",
            "data"    => $query
        ]);
    }
    public function receive(Request $request)
    {
        $user_code = $request->user()->user_code;
        $businessCode = $request->user()->business_code;
        $query = DB::select('SELECT
                `product_information`.`id` AS `product ID`,
                `product_information`.`product_name` AS `Product Name`,
                `inventory_allocations`.`status`,
                `inventory_allocations`.`date_allocated`,
                `inventory_allocated_items`.`allocated_qty` AS `Quantity Allocated`,
                `inventory_allocated_items`.`business_code`
            FROM
                `product_information`
            INNER JOIN `inventory_allocations` ON `inventory_allocations`.`business_code` = `product_information`.`business_code`
            INNER JOIN `inventory_allocated_items` ON `inventory_allocations`.`allocation_code` = `inventory_allocated_items`.`allocation_code`
            WHERE
                `product_information`.`business_code` = ? AND `inventory_allocations`.`sales_person` = ?', [$businessCode, $user_code]);

        return response()->json([
            "success" => true,
            "message" => "All Available Product Information",
            "data"    => $query
        ]);
    }
}
