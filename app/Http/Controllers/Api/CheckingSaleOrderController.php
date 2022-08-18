<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\customer\checkin;
use App\Models\products\product_information;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class CheckingSaleOrderController extends Controller
{

    public function amount(Request $request,$checkinCode){
        $checkin = checkin::where('code', $checkinCode)->first();
        $request = $request->all();
        $total=0;
        array_pop($request);
        foreach ($request as $value){
            $product = product_information::join('product_price',
            'product_price.productID', '=', 'product_information.id')
           ->where('product_information.id', $value["productID"])
           ->where('product_information.business_code', $checkin->business_code)
           ->first();
           $total_amount = $value["qty"] * $product->selling_price;
           $total+=$total_amount;
        }
        return $total;
        }

    //Start Vansales
    public function VanSales(Request $request, $checkinCode)
    {
        $amountRequest=$request;
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
            $random = Str::random(8);
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
            `created_at`)
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
                'Van Sale', 
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
            `updated_at`
        )
        VALUES (?,?,?, ?,?, ?,?, ?,?, ?,?,?)',
            [
                $random, 
                $value["productID"], 
                $product->product_name, 
                $value["qty"],
                $value["qty"] * $product->selling_price, 
                $value["qty"] * $product->selling_price,
                0, 
                0, 
                0, 
                0, 
                now(), 
                now()
            ]
        );
        return response()->json([
            "success" => true,
            "message" => "Product added to order",
            "data"    => $checkin
        ]);
    }

    //End of Vansales 


    // Beginning of NewSales
    public function NewSales(Request $request, $checkinCode)
    {
        $amountRequest=$request;
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
        return response()->json([
            "success" => true,
            "message" => "Product added to order",
            "data"    => $checkin
        ]);
    }
}
