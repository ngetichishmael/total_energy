<?php

namespace App\Http\Controllers\Api\Total;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Delivery_items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
   public function partialDelivery(Request $request, $delivery_code)
   {
      $user_code = $request->user()->user_code;
      $requests = $request->collect();

      Delivery::where('delivery_code', $delivery_code)->update([
         'delivery_status' => "Partial delivery"
      ]);
      foreach ($requests as $value) {
         Delivery_items::updateOrCreate(
            [
               "business_code" => Auth::user()->business_code,
               "delivery_code" => $delivery_code,
               "productID" => $value["productID"],

            ],
            [
               "delivered_quantity" => $value["qty"],
               "created_by" => $user_code,
               "updated_by" => $user_code
            ]
         );
      }
      return response()->json([
         "success" => true,
         "message" => "Product added to order",
      ]);
   }
   public function fullDelivery(Request $request, $delivery_code)
   {
      $user_code = $request->user()->user_code;
      $requests = $request->collect();

      Delivery::where('delivery_code', $delivery_code)->update([
         'delivery_status' => "DELIVERED",
      ]);
      foreach ($requests as $value) {
         Delivery_items::updateOrCreate(
            [
               "business_code" => Auth::user()->business_code,
               "delivery_code" => $delivery_code,
               "productID" => $value["productID"],

            ],
            [
               "delivered_quantity" => $value["qty"],
               "created_by" => $user_code,
               "updated_by" => $user_code
            ]
         );
      }
      return response()->json([
         "success" => true,
         "message" => "Product added to order",
      ]);
   }

   public function editDelivery(Request $request, $delivery_code)
   {
      $user_code = $request->user()->user_code;
      $requests = $request->collect();

      Delivery::where('delivery_code', $delivery_code)->update([
         'delivery_status' => "Partial delivery"
      ]);
      foreach ($requests as $value) {
         Delivery_items::updateOrCreate(
            [
               "business_code" => Auth::user()->business_code,
               "delivery_code" => $delivery_code,
               "productID" => $value["productID"],

            ],
            [
               "delivered_quantity" => $value["qty"],
               "created_by" => $user_code,
               "updated_by" => $user_code
            ]
         );
      }
      return response()->json([
         "success" => true,
         "message" => "Product added to order",
      ]);
   }
   public function cancel(Request $request)
   {
      Delivery::where('order_code', $request->order_code)->update(
         [
            "delivery_status" => "cancelled"
         ]
      );
      return response()->json([
         "success" => true,
         "message" => "Delivery Cancelled Successfully",
         "order_code" => $request->order_code,
      ]);
   }
}
