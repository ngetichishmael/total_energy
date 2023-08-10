<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\inventory\allocations;
use App\Models\inventory\items;
use App\Models\products\product_inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StockLiftController extends Controller
{
    public function index(Request $request)
    {
        $user_code = $request->user()->user_code;
        $business_code = $request->user()->business_code;
        $random = Str::random(20);
        info("Stock Lift");
        $json = $request->products;
        $data = json_decode($json, true);

        $validator = Validator::make($request->all(), [
            "image" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => 401,
                    "message" => "validation_error",
                    "errors" => $validator->errors(),
                ],
                403
            );
        }

        $image_path = $request->file('image')->store('image', 'public');
        foreach ($data as $value) {
            $stock = items::where('product_code', $value["productID"])
                ->where('created_by', $user_code)
                ->pluck('product_code')
                ->implode('');
            if ($stock == null) {
                $stocked = product_inventory::where('productID', $value["productID"])->first();
                info($stocked);
                $itemchecker = items::create([
                    'business_code' => $business_code,
                    'allocation_code' => $random,
                    'product_code' => $value["productID"],
                    'current_qty' => $stocked["current_stock"],
                    'allocated_qty' => $value["qty"],
                    'image' => $image_path,
                    'returned_qty' => 0,
                    'created_by' => $user_code,
                    'updated_by' => $user_code,
                ]);
                info("itemchecker");
                info($itemchecker);
            } else {

                $inventoryallocation = DB::table('inventory_allocated_items')
                    ->where('product_code', $value["productID"])
                    ->increment('allocated_qty', $value["qty"]);

                info("inventory_allocated_items");
                info($inventoryallocation);
            }
            $producting = DB::table('product_inventory')
                ->where('productID', $value["productID"])
                ->decrement('current_stock', $value["qty"]);

            info("Product inventory");
            info($producting);
        }
        $checkeddd = allocations::create([
            "business_code" => $business_code,
            "allocation_code" => $random,
            "sales_person" => $user_code,
            "status" => "Waiting acceptance",
            "created_by" => $user_code,
        ]);
        info("checkeddd");
        info($checkeddd);
        return response()->json([
            "success" => true,
            "message" => "All Available Product Information",
            "Result" => "Successful",
        ]);
    }
    public function show(Request $request)
    {
        $businessCode = $request->user()->business_code;
        $supplierID = $request->supplierID;

        $query = DB::table('product_information')
            ->select(
                'product_information.supplierID as SupplierID',
                'product_information.business_code as business_code',
                'product_information.sku_code',
                'product_information.brand',
                'product_information.category',
                'product_information.id AS productID',
                'product_information.created_at as date',
                'product_information.product_name as product_name',
                'product_price.selling_price as price',
                'product_inventory.current_stock AS current_stock'
            )
            ->join('product_inventory', 'product_inventory.business_code', '=', 'product_information.business_code')
            ->join('product_price', 'product_price.productID', '=', 'product_information.id')
            ->where([
                ['product_information.business_code', '=', $businessCode],
                ['product_information.supplierID', '=', $supplierID],
            ])
            ->groupBy('productID')
            ->get();

        return response()->json([
            "success" => true,
            "message" => "All Available Product Information filtered by Distributers",
            "data" => $query,
        ]);
    }

    public function receive(Request $request)
    {
        $userCode = $request->user()->user_code;
        $businessCode = $request->user()->business_code;

        $query = DB::table('product_information')
            ->select(
                'product_information.id AS product_ID',
                'product_information.product_name AS Product_Name',
                'inventory_allocations.status',
                'inventory_allocations.date_allocated',
                'inventory_allocated_items.allocated_qty AS Quantity_Allocated',
                'inventory_allocated_items.business_code'
            )
            ->join('inventory_allocations', 'inventory_allocations.business_code', '=', 'product_information.business_code')
            ->join('inventory_allocated_items', 'inventory_allocations.allocation_code', '=', 'inventory_allocated_items.allocation_code')
            ->where([
                ['product_information.business_code', '=', $businessCode],
                ['inventory_allocations.sales_person', '=', $userCode],
            ])
            ->get();

        return response()->json([
            "success" => true,
            "message" => "All Available Product Information",
            "data" => $query,
        ]);
    }

}
