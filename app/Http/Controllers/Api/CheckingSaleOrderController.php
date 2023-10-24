<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\customer\checkin;
use App\Models\customer\customers;
use App\Models\Orders as Order;
use App\Models\Order_items;
use App\Models\products\product_information;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckingSaleOrderController extends Controller
{

    public function amount(Request $request, $checkinCode)
    {
        $checkin = checkin::where('code', $checkinCode)->first();
        $request = $request->collect();
        $total = 0;
        foreach ($request as $value) {
            $product = product_information::with('ProductPrice')
                ->where('id', $value["productID"])
                ->where('business_code', $checkin->business_code)
                ->first();
            $total_amount = $value["qty"] * $value["price"];
            $total += $total_amount;
        }
        return $total;
    }

    //Start Vansales
    public function VanSales(Request $request, $checkinCode, $random)
    {
        $checkin = checkin::where('code', $checkinCode)->first();
        $user_code = $request->user()->user_code;
        $total = 0;
        $request = $request->collect();
        foreach ($request as $value) {
            $price_total = $value["qty"] * $value["price"];
            $total += $price_total;
            $product = product_information::with('ProductPrice')->where('id', $value["productID"])->first();
            Cart::updateOrCreate(
                [
                    'checkin_code' => $checkinCode,
                    "order_code" => $random,
                ],
                [
                    'productID' => $value["productID"],
                    "product_name" => $product->product_name,
                    "qty" => $value["qty"],
                    "price" => $value["price"],
                    "amount" => $value["qty"] * $value["price"],
                    "total_amount" => $value["qty"] * $value["price"],
                    "userID" => $user_code,
                ]
            );
            DB::table('inventory_allocated_items')
                ->where('product_code', $value["productID"])
                ->decrement(
                    'allocated_qty',
                    $value["qty"],
                    [
                        'updated_at' => now(),
                    ]
                );
            Order::updateOrCreate(
                [

                    'order_code' => $random,
                ],
                [
                    'user_code' => $user_code,
                    'customerID' => $checkin->customer_id,
                    'price_total' => $total,
                    'balance' => $total,
                    'order_status' => 'Pending Delivery',
                    'payment_status' => 'Pending Payment',
                    'qty' => $value["qty"],
                    'discount' => $product->discount ?? "0",
                    'checkin_code' => $checkinCode,
                    'order_type' => 'Van sales',
                    'delivery_date' => now(),
                    'business_code' => $checkin->business_code,
                    'updated_at' => now(),
                ]
            );
            Order_items::create([
                'order_code' => $random,
                'productID' => $value["productID"],
                'product_name' => $product->product_name,
                'quantity' => $value["qty"],
                'sub_total' => $value["qty"] * $value["price"],
                'total_amount' => $value["qty"] * $value["price"],
                'selling_price' => $value["price"],
                'discount' => $product->discount ?? "0",
                'taxrate' => 0,
                'taxvalue' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
       $customer = customers::find($checkin->customer_id);

       if ($customer) {
          $customer->update([
             'last_order_date' => Carbon::now(),
          ]);
       }
        return response()->json([
            "success" => true,
            "message" => "Product added to order",
            "order_code" => $random,
            "data" => $checkin,
        ]);
    }

    //End of Vansales
    //Start Vansales

    // Beginning of NewSales
    public function NewSales(Request $request, $checkinCode, $random)
    {
        $user_code = $request->user()->user_code;
        $request1 = $request->collect();
        $total = 0;
       $ordercode =$random;

       foreach ($request1 as $value) {
          if (empty($value)) {
             continue;
          }

          $qty = $value["qty"];
          $price = $value["price"];
          $productID = $value["productID"];

          $product = product_information::find($productID);

          if ($product) {
             $price_total = $qty * $price;
             $total += $price_total;

             // Create or update the cart
             Cart::updateOrCreate(
                [
                   'checkin_code' => Str::random(20),
                   "order_code" => $ordercode,
                ],
                [
                   'productID' => $productID,
                   "product_name" => $product->product_name,
                   "qty" => $qty,
                   "price" => $price,
                   "amount" => $price_total,
                   "total_amount" => $price_total,
                   "userID" => $user_code,
                ]
             );

             // Create or update the order
             Order::updateOrCreate(
                [
                   'order_code' => $ordercode,
                ],
                [
                   'user_code' => $user_code,
                   'customerID' => $checkinCode,
                   'price_total' => $total,
                   'balance' => $total,
                   'order_status' => 'Pending Delivery',
                   'payment_status' => 'Pending Payment',
                   'qty' => $qty,
                   'supplierID' => $distributor ?? 1,
                   'discount' => $value["discount"] ?? 0,
                   'checkin_code' => $checkinCode,
                   'order_type' => 'Pre Order',
                   'delivery_date' => now(),
                   'business_code' => $user_code,
                   'updated_at' => now(),
                ]
             );

             // Create order items
             Order_items::create([
                'order_code' => $ordercode,
                'productID' => $productID,
                'product_name' => $product->product_name,
                'quantity' => $qty,
                'sub_total' => $price_total,
                'total_amount' => $price_total,
                'selling_price' => $price,
                'discount' => 0,
                'taxrate' => 0,
                'taxvalue' => 0,
                'created_at' => now(),
                'updated_at' => now(),
             ]);

             // Update orders_targets
             DB::table('orders_targets')
                ->where('user_code', $user_code)
                ->increment('AchievedOrdersTarget', $qty);
          }
       }
//        foreach ($request as $value) {
//            $price_total = $value["qty"] * $value["price"];
//            $total += $price_total;
//            $product = product_information::whereId($value["productID"])->first();
//            Cart::updateOrCreate(
//                [
//                    'checkin_code' => Str::random(20),
//                    "order_code" => $random,
//                ],
//                [
//                    'productID' => $value["productID"],
//                    "product_name" => $product->product_name,
//                    "qty" => $value["qty"],
//                    "price" => $value["price"],
//                    "amount" => $value["qty"] * $value["price"],
//                    "total_amount" => $value["qty"] * $value["price"],
//                    "userID" => $user_code,
//                ]
//            );
//            Order::updateOrCreate(
//                [
//                    'order_code' => $random,
//                ],
//                [
//                    'user_code' => $user_code,
//                    'customerID' => $checkinCode,
//                    'price_total' => $total,
//                    'balance' => $total,
//                    'order_status' => 'Pending Delivery',
//                    'payment_status' => 'Pending Payment',
//                    'qty' => $value["qty"],
//                    'discount' => $product->discount ?? "0",
//                    'checkin_code' => $checkinCode,
//                    'order_type' => 'Pre Order',
//                    'delivery_date' => now(),
//                    'business_code' => $user_code,
//                    'updated_at' => now(),
//                ]
//            );
//            Order_items::create([
//                'order_code' => $random,
//                'productID' => $value["productID"],
//                'product_name' => $product->product_name,
//                'quantity' => $value["qty"],
//                'sub_total' => $value["qty"] * $value["price"],
//                'total_amount' => $value["qty"] * $value["price"],
//                'selling_price' => $value["price"],
//                'discount' => 0,
//                'taxrate' => 0,
//                'taxvalue' => 0,
//                'created_at' => now(),
//                'updated_at' => now(),
//            ]);
//
//            DB::table('orders_targets')
//                ->where('user_code', $user_code)
//                ->increment('AchievedOrdersTarget', $value["qty"]);
//        }
       $customer = customers::find($checkinCode);

       if ($customer) {
          $customer->update([
             'last_order_date' => Carbon::now(),
          ]);
       }
        return response()->json([
            "success" => true,
            "message" => "Product added to order",
            "order_code" => $random,
            "data" => null,
        ]);
    }
}
