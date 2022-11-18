<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\customer\checkin;
use App\Models\products\product_information;
use App\Models\Cart;
use App\Models\inventory\items;
use App\Models\Order_items;
use App\Models\Orders as Order;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;


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
         $total_amount = $value["qty"] * $product->ProductPrice->selling_price;
         $total += $total_amount;
      }
      return $total;
   }

   //Start Vansales
   public function VanSales(Request $request, $checkinCode,$random)
   {
      $amountRequest = $request;
      $checkin = checkin::where('code', $checkinCode)->first();
      $user_code = $request->user()->user_code;
      $request = $request->collect();
      foreach ($request as $value) {
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
               "price" => $product->ProductPrice->selling_price,
               "amount" => $value["qty"] * $product->ProductPrice->selling_price,
               "total_amount" => $value["qty"] * $product->ProductPrice->selling_price,
               "userID" => $user_code,
            ]
         );
         DB::table('inventory_allocated_items')
            ->where('product_code', $value["productID"])
            ->decrement(
               'allocated_qty',
               $value["qty"],
               [
                  'updated_at' => now()
               ]
            );
         Order::updateOrCreate(
            [

               'order_code' => $random,
            ],[
            'user_code' => $user_code,
            'customerID' => $checkin->customer_id,
            'price_total' => $this->amount($amountRequest, $checkinCode),
            'balance' => $this->amount($amountRequest, $checkinCode),
            'order_status' => 'Pending Delivery',
            'payment_status' => 'Pending Payment',
            'qty' => $value["qty"],
            'checkin_code' => $checkinCode,
            'order_type' => 'Van sales',
            'delivery_date' => now(),
            'business_code' => $checkin->business_code,
            'updated_at' => now(),
         ]);
         Order_items::create([
            'order_code' => $random,
            'productID' => $value["productID"],
            'product_name' => $product->product_name,
            'quantity' => $value["qty"],
            'sub_total' => $value["qty"] * $product->selling_price,
            'total_amount' => $value["qty"] * $product->selling_price,
            'selling_price' => 0,
            'discount' => 0,
            'taxrate' => 0,
            'taxvalue' => 0,
            'created_at' => now(),
            'updated_at' => now(),
         ]);
      }
      return response()->json([
         "success" => true,
         "message" => "Product added to order",
         "order_code" => $random,
         "data"    => $checkin
      ]);
   }

   //End of Vansales


   // Beginning of NewSales
   public function NewSales(Request $request, $checkinCode,$random)
   {
      $amountRequest = $request;
      $checkin = checkin::where('code', $checkinCode)->first();
      $user_code = $request->user()->user_code;
      $request = $request->collect();
      foreach ($request as $value) {
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
               "price" => $product->ProductPrice->selling_price,
               "amount" => $value["qty"] * $product->ProductPrice->selling_price,
               "total_amount" => $value["qty"] * $product->ProductPrice->selling_price,
               "userID" => $user_code,
            ]
         );
         Orders::updateOrCreate(
            [

               'order_code' => $random,
            ],
            [
            'user_code' => $user_code,
            'customerID' => $checkin->customer_id,
            'price_total' => $this->amount($amountRequest, $checkinCode),
            'balance' => $this->amount($amountRequest, $checkinCode),
            'order_status' => 'Pending Delivery',
            'payment_status' => 'Pending Payment',
            'qty' => $value["qty"],
            'checkin_code' => $checkinCode,
            'order_type' => 'Pre Order',
            'delivery_date' => now(),
            'business_code' => $checkin->business_code,
            'created_at' => now()
         ]);
         Order_items::create([
            'order_code' => $random,
            'productID' => $value["productID"],
            'product_name' => $product->product_name,
            'quantity' => $value["qty"],
            'sub_total' => $value["qty"] * $product->selling_price,
            'total_amount' => $value["qty"] * $product->selling_price,
            'selling_price' => 0,
            'discount' => 0,
            'taxrate' => 0,
            'taxvalue' => 0,
            'created_at' => now(),
            'updated_at' => now(),
         ]);

         DB::table('orders_targets')
            ->where('user_code', $user_code)
            ->increment('AchievedOrdersTarget', $value["qty"] * $product->selling_price);
      }
      return response()->json([
         "success" => true,
         "message" => "Product added to order",
         "order_code" => $random,
         "data"    => $checkin
      ]);
   }
}
