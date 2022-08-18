<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\customer\checkin;
use App\Models\products\product_information;
use App\Models\Cart;
use App\Models\Orders as Order;
use Illuminate\Support\Facades\DB;

class CheckingSaleOrderController extends Controller
{
    //Start Vansales
    public function VanSales(Request $request, $checkinCode)
    {
        $checkin = checkin::where('code', $checkinCode)->first();
        $user_code = $request->user()->user_code;
        $business_code = $request->user()->business_code;
        $random = Str::random(8);
        $total=0;
        $quanty=0;
        foreach ($request->productID as $key => $value) {
                $product = product_information::join('product_price','product_price.productID', '=', 'product_information.id')
               ->where('product_information.id', $value)
               ->where('product_information.business_code', $checkin->business_code)
               ->first();
               $total+=$request->qty[$key] * $product->selling_price;
               $quanty+=$request->qty[$key];
                $checkInCart = Cart::where('checkin_code', $checkinCode)->where('productID', 15)->count();
                if ($checkInCart > 0) {
                    $cart = Cart::where('checkin_code', $checkinCode)->where('productID', $value)->first();
                    $cart->qty = $request->qty[$key];
                    $cart->price = $product->selling_price;
                    $cart->amount =  $request->qty[$key] * $product->selling_price;
                    $cart->total_amount = $request->qty[$key] * $product->selling_price;
                    $cart->userID = $user_code;
                    $cart->save();
                } else {
                    $cart = new Cart;
                    $cart->productID = $value["productID"];
                    $cart->product_name = $product->product_name;
                    $cart->qty =  $request->qty[$key];
                    $cart->price = $product()->selling_price;
                    $cart->amount =  $request->qty[$key] * $product->selling_price;
                    $cart->userID = $user_code;
                    $cart->customer_account = $checkin->account_number;
                    $cart->total_amount =  $request->qty[$key] * $product->selling_price;
                    $cart->checkin_code = $checkinCode;
                    $cart->save();
                }
                $order = Order::updateOrCreate(
                    [
                        'order_code' => $random, 
                        'user_code' =>  $user_code,
                        'customerID'=>$checkin->customer_id,
                        'checkin_code'=> $checkinCode,
                        'order_type' => 'Van Sale'
                    ],
                    [
                        'price_total' =>$total,
                        'balance' =>$total,
                        'order_status'=>'Pending Payment',
                        'payment_status'=>'Pending Payment',
                        'qty'=>$quanty,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                        'business_code'=> $business_code
                    ]
                );
            }
            return response()->json([
                "success" => true,
                "message" => "Product added to order",
                "data"    => $checkin
            ]);
        }
    //End of Vansales 


    //Start Newsales
    public function NewSales(Request $request, $checkinCode)
    {
        $checkin = checkin::where('code', $checkinCode)->first();
        $user_code = $request->user()->user_code;
        $business_code = $request->user()->business_code;
        $random = Str::random(8);
        $total=0;
        $quanty=0;
        foreach ($request->productID as $key => $value) {
                $product = product_information::join('product_price','product_price.productID', '=', 'product_information.id')
               ->where('product_information.id', $value)
               ->where('product_information.business_code', $checkin->business_code)
               ->first();
               $total+=$request->qty[$key] * $product->selling_price;
               $quanty+=$request->qty[$key];
                $checkInCart = Cart::where('checkin_code', $checkinCode)->where('productID', 15)->count();
                if ($checkInCart > 0) {
                    $cart = Cart::where('checkin_code', $checkinCode)->where('productID', $value)->first();
                    $cart->qty = $request->qty[$key];
                    $cart->price = $product->selling_price;
                    $cart->amount =  $request->qty[$key] * $product->selling_price;
                    $cart->total_amount = $request->qty[$key] * $product->selling_price;
                    $cart->userID = $user_code;
                    $cart->save();
                } else {
                    $cart = new Cart;
                    $cart->productID = $value["productID"];
                    $cart->product_name = $product->product_name;
                    $cart->qty =  $request->qty[$key];
                    $cart->price = $product()->selling_price;
                    $cart->amount =  $request->qty[$key] * $product->selling_price;
                    $cart->userID = $user_code;
                    $cart->customer_account = $checkin->account_number;
                    $cart->total_amount =  $request->qty[$key] * $product->selling_price;
                    $cart->checkin_code = $checkinCode;
                    $cart->save();
                }
                $order = Order::updateOrCreate(
                    [
                        'order_code' => $random, 
                        'user_code' =>  $user_code,
                        'customerID'=>$checkin->customer_id,
                        'checkin_code'=> $checkinCode,
                        'order_type' => 'Pre order'
                    ],
                    [
                        'price_total' =>$total,
                        'balance' =>$total,
                        'order_status'=>'Pending Payment',
                        'payment_status'=>'Pending Payment',
                        'qty'=>$quanty,
                        'created_at'=>now(),
                        'updated_at'=>now(),
                        'business_code'=> $business_code
                    ]
                );
            }
            return response()->json([
                "success" => true,
                "message" => "Product added to order",
                "data"    => $checkin
            ]);
        }
    //End of New Sales

    }