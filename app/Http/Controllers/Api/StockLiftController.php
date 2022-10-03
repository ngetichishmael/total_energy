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
        $request = $request->all();
        info($request);
        array_pop($request);
        foreach ($request as $value) {
            $stock = DB::select('SELECT `product_code`  FROM `inventory_allocated_items` WHERE `product_code` =? AND `created_by`= ?', [$value["productID"], $user_code]);
            $check = $stock == null  ? $stock:"Hello World" ;
            info($check);
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
                DB::update('UPDATE
                `inventory_allocated_items`
                    SET   `allocated_qty` = `allocated_qty`+? where `product_code` = ?', [$value["qty"],$value["productID"]]);
            }
            $stock =null;
        }
        DB::insert(
            'INSERT INTO `inventory_allocations`(
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
            [
                $business_code,
                $random,
                $user_code,
                'Waiting acceptance',
                $user_code,
                $user_code,
                now(),
                now()
            ]
        );

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
        // Hello wo
        $query = DB::select('SELECT
        `suppliers`.`name` AS `Distributer`,
        `suppliers`.`id`,
        `product_information`.`business_code` as `business_code`,
        `product_information`.`sku_code`,
        `product_information`.`brand`,
        `product_information`.`category`,
        `product_information`.`id` AS `product ID`,
        `product_information`.`created_at` as `date`,
        `product_information`.`product_name` as `product_name`,
        `product_price`.`selling_price` as `price`,
        `product_inventory`.`current_stock` AS `current stock`,
        `product_information`.`product_name` AS `product name`
            FROM
                `product_information`
            INNER JOIN `business` ON `business`.`business_code` = `product_information`.`business_code`
            INNER JOIN `suppliers` ON `suppliers`.`business_code` = `product_information`.`business_code`
            INNER JOIN `product_inventory` ON `product_inventory`.`business_code` = `suppliers`.`business_code`
            INNER JOIN `product_price` ON `product_price`.`productID` = `product_information`.`id`
            WHERE
                `product_information`.`business_code` = ? AND `suppliers`.`id` = ?
            ORDER BY
                `product ID`
            DESC', [$businessCode,$supplierID]);

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
