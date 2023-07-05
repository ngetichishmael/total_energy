<?php

namespace App\Http\Controllers\app;

use App\Models\User;
use App\Models\Orders;
use App\Models\Delivery;
use App\Models\customers;
use App\Models\Order_items;
use App\Models\warehousing;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Delivery_items;
use App\Models\order_payments;
use App\Http\Controllers\Controller;
use App\Models\products\product_price;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ordersController extends Controller
{
   //orders
   public function index()
   {
      return view('app.orders.index');
   }

   public function makeOrder($id)
   {
      return view('app.orders.make', [
         'id' => $id,
      ]);
   }
   public function pendingdeliveries()
   {
      return view('app.orders.pendingdeliveries');
   }
   public function vansalesorders()
   {
      return view('app.orders.distributororders');
   }
   public function pendingorders()
   {
      return view('app.orders.pendingorders');
   }
   //order details
   public function details($code)
   {
      $order = Orders::where('order_code', $code)->first();
      // dd($code);
      $items = Order_items::where('order_code', $order->order_code)->get();
      $sub = Order_items::select('sub_total')->where('order_code', $order->order_code)->get();
      $total = Order_items::select('total_amount')->where('order_code', $order->order_code)->get();
      $Customer_id = Orders::select('customerID')->where('order_code', $code)->first();
      $id = $Customer_id->customerID;
      $test = customers::where('id', $id)->first();
      // dd($test->id);
      $payment = order_payments::where('order_id', $order->order_code)->first();
      // dd($payment);
      return view('app.orders.details', compact('order', 'items', 'test', 'payment', 'sub', 'total'));
   }

   //allocation
   public function allocation($code)
   {
      $order = Orders::where('order_code', $code)->first();
      $items = Order_items::where('order_code', $order->order_code)->get();
      $users = User::orderby('id', 'desc')->get();
      $warehouses = warehousing::orderby('id', 'desc')->get();

      return view('app.orders.allocation', compact('order', 'items', 'users', 'warehouses'));
   }

   //create delivery
   public function delivery(Request $request)
   {
      $this->validate($request, [
         'user' => 'required',
         'warehouse' => 'required',

      ]);

      $delivery = Delivery::updateOrCreate(
         [
            "business_code" => Auth::user()->business_code,
            "customer" => $request->customer,
            "order_code" => $request->order_code
         ],
         [
            "delivery_code" => Str::random(20),
            "allocated" => $request->user,
            "delivery_note" => $request->note,
            "delivery_status" => "Waiting acceptance",
            "created_by" => Auth::user()->user_code
         ]
      );

      for ($i = 0; $i < count($request->allocate); $i++) {

         $pricing = product_price::whereId($request->item_code[$i])->first();
         Delivery_items::updateOrCreate(
            [
               "business_code" => Auth::user()->business_code,
               "delivery_code" => $delivery->delivery_code,
               "productID" => $request->item_code[$i],

            ],
            [
               "selling_price" => $pricing->selling_price,
               "sub_total" => $pricing->selling_price * $request->allocate[$i],
               "total_amount" => $pricing->selling_price * $request->allocate[$i],
               "product_name" => $request->product[$i],
               "allocated_quantity" => $request->allocate[$i],
               "delivery_item_code" => Str::random(20),
               "created_by" => Auth::user()->user_code,
               "requested_quantity" => $request->requested[$i],
               "created_by" => Auth::user()->user_code
            ]
         );
         Order_items::where('productID', $request->item_code[$i])
            ->where('order_code', $request->order_code)
            ->update([
               "requested_quantity" => $request->product[$i]
            ]);
      }

      Session::flash('success', 'Delivery created and orders allocated');

      return redirect()->route('delivery.index');
   }
}
