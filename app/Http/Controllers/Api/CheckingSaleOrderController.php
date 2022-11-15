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
use Illuminate\Support\Facades\DB;


class CheckingSaleOrderController extends Controller
{

   public function amount(Request $request, $checkinCode)
   {
      $checkin = checkin::where('code', $checkinCode)->first();
      $request = $request->all();
      $total = 0;
      array_pop($request);
      foreach ($request as $value) {
         $product = product_information::join(
            'product_price',
            'product_price.productID',
            '=',
            'product_information.id'
         )
            ->where('product_information.id', $value["productID"])
            ->where('product_information.business_code', $checkin->business_code)
            ->first();
         $total_amount = $value["qty"] * $product->selling_price;
         $total += $total_amount;
      }
      return $total;
   }

   //Start Vansales
   public function VanSales(Request $request, $checkinCode)
   {
      $amountRequest = $request;
      $checkin = checkin::where('code', $checkinCode)->first();
      $user_code = $request->user()->user_code;
      $request = $request->collect();
      // array_pop($request);
      foreach ($request as $value) {
         $product = product_information::with('ProductPrice')->where('id', $value["productID"])->first();
         $random = Str::random(8);
         Cart::updateOrCreate(
            [
               'checkin_code' => $checkinCode,
               'productID' => $value["productID"]
            ],
            [
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
         Order::create([
            'order_code' => $random,
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
   public function NewSales(Request $request, $checkinCode)
   {
      $amountRequest = $request;
      $checkin = checkin::where('code', $checkinCode)->first();
      $user_code = $request->user()->user_code;
      $request = $request->all();
      array_pop($request);
      foreach ($request as $value) {
         $product = product_information::join(
            'product_price',
            'product_price.productID',
            '=',
            'product_information.id'
         )
            ->where('product_information.id', $value["productID"])
            ->where('product_information.business_code', $checkin->business_code)
            ->first();
         $checkInCart = Cart::where('checkin_code', $checkinCode)->where('productID', $value["productID"])->count();
         if ($checkInCart > 0) {
            $cart = Cart::where('checkin_code', $checkinCode)->where('productID', $value["productID"])->first();
            $cart->qty = $value["qty"];
            $cart->price = $product->selling_price;
            $cart->amount = $value["qty"] * $product->selling_price;
            $cart->total_amount = $value["qty"] * $product->selling_price;
            $cart->userID = $user_code;
            $cart->save();
         } else {
            $cart = new Cart;
            $cart->productID = $value["productID"];
            $cart->product_name = $product->product_name;
            $cart->qty = $value["qty"];
            $cart->price = $product->selling_price;
            $cart->amount = $value["qty"] * $product->selling_price;
            $cart->userID = $user_code;
            $cart->customer_account = $checkin->account_number;
            $cart->total_amount = $value["qty"] * $product->selling_price;
            $cart->checkin_code = $checkinCode;
            $cart->save();
         }
         $random = Str::random(8);
         DB::insert(
            'INSERT INTO `orders`(
            `order_code`,
            `user_code`,
            `customerID`,
            `price_total`,
            `balance`,
            `order_status`,
            `payment_status`,
            `qty`,
            `checkin_code`,
            `order_type`,
            `delivery_date`,
            `business_code`,
            `created_at`
            )

        VALUES (?,?,?, ?,?, ?,?, ?,?, ?,?,?,?)',

            [
               $random,
               $user_code,
               $checkin->customer_id,
               $this->amount($amountRequest, $checkinCode),
               $this->amount($amountRequest, $checkinCode),
               'Pending Delivery',
               'Pending Payment',
               $value["qty"],
               $checkinCode,
               'Pre Order',
               now(),
               $checkin->business_code,
               now()
            ]
         );

         DB::insert(
            'INSERT INTO `order_items`(
        `order_code`,
        `productID`,
        `product_name`,
        `quantity`,
        `sub_total`,
        `total_amount`,
        `selling_price`,
        `discount`,
        `taxrate`,
        `taxvalue`,
        `created_at`,
        `updated_at`)

        VALUES (?,?,?, ?,?, ?,?, ?,?, ?,?,?)',
            [
               $random,
               $value["productID"],
               $product->product_name,
               $value["qty"],
               $value["qty"] * $product->selling_price,
               $value["qty"] * $product->selling_price,
               0, 0, 0, 0, now(), now()
            ]
         );
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
