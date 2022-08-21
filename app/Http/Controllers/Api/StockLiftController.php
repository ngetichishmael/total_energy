<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        //array_pop($request);
        foreach ($request as $value) {
           DB::insert('INSERT INTO `inventory_allocated_items`(
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
                    [$business_code, 
                     $random,
                     $value["productID"],
                     $value["productID"],
                     $value["qty"],
                     0,
                     $user_code,
                     $user_code,
                     now(),
                     now()
                    ]);
                    info($value);
        }
        DB::insert('INSERT INTO `inventory_allocations`(
            `business_code`,
            `allocation_code`,
            `sales_person`,
            `status`,
            `created_by`,
            `updated_by`,
            `created_at`,
            `updated_at`
        )
        VALUES(?,?,?,?,?,?,?,?)', 
              [$business_code, 
              $random,
              $user_code,
              'Waiting acceptance',
              $user_code,
              $user_code,
              now(),
              now()
              ]);

        return response()->json([
            "success" => true,
            "message" => "All Available Product Information",
            "Result"    => "Successful"
        ]);
        
    }
    public function show(Request $request)
    {
        $businessCode=$request->user()->business_code;
        $query = DB::select('SELECT
        `product_information`.`id` AS `product ID`,
        `product_inventory`.`current_stock` AS `current stock`,
        `product_information`.`product_name` AS `product name`
            FROM
                `product_information`
            INNER JOIN `business` ON `business`.`business_code` = `product_information`.`business_code`
            INNER JOIN `product_inventory` ON `product_inventory`.`productID` = `product_information`.`id`
            INNER JOIN `product_price` ON `product_price`.`productID` = `product_information`.`id`
            WHERE
                `product_information`.`business_code` = ?
            ORDER BY
                `product ID`
            DESC', [$businessCode]);

            return response()->json([
                "success" => true,
                "message" => "All Available Product Information",
                "data"    => $query
            ]);
    }
}
