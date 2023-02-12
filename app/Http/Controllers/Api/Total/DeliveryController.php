<?php

namespace App\Http\Controllers\Api\Total;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Delivery_items;
use App\Models\products\product_information;
use App\Models\products\product_price;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
   public function partialDelivery(Request $request, $delivery_code)
   {
      $user_code = $request->user()->user_code;
      $requests = $request->collect();

      Delivery::where('delivery_code', $delivery_code)->update([
         'delivery_status' => "Partial delivery"
      ]);
      $total = 0;
      foreach ($requests as $value) {

         Delivery_items::updateOrCreate(
            [
               "business_code" => $request->user()->business_code,
               "delivery_code" => $delivery_code,
               "productID" => $value["productID"],

            ],
            [
               "delivered_quantity" => $value["qty"],
               "item_condition" => $value["item_condition"],
               "note" => $value["note"],
               "created_by" => $user_code,
               "updated_by" => $user_code
            ]
         );
         $total += product_price::whereId($value["productID"])->pluck('buying_price')->implode(" ") * $value["qty"];
      }
      return response()->json([
         "success" => true,
         "message" => "Partial delivery was successful",
         "total" => $total
      ]);
   }
   public function fullDelivery(Request $request, $delivery_code)
   {
      $user_code = $request->user()->user_code;
      $requests = $request->collect();

      Delivery::where('delivery_code', $delivery_code)->update([
         'delivery_status' => "DELIVERED",
      ]);
      $total = 0;
      foreach ($requests as $value) {
         Delivery_items::updateOrCreate(
            [
               "business_code" => $request->user()->business_code,
               "delivery_code" => $delivery_code,
               "productID" => $value["productID"],

            ],
            [
               "delivery_quantity" => $value["qty"],
               "created_by" => $user_code,
               "updated_by" => $user_code
            ]
         );

         $total += product_price::whereId($value["productID"])->pluck('buying_price')->implode(" ") * $value["qty"];
      }
      return response()->json([
         "success" => true,
         "message" => "Delivery Successful",
         "total" => $total
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
               "business_code" => $request->user()->business_code,
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
         "message" => "Edit product successfully",
      ]);
   }
   public function cancel(Request $request, $delivery_code)
   {
      Delivery::where('delivery_code', $delivery_code)->update(
         [
            "delivery_status" => "cancelled",
            'updated_by' => $request->user()->user_code,
         ]
      );


      return response()->json([
         "success" => true,
         "message" => "Delivery Cancelled Successfully",
         "order_code" => $request->order_code,
      ]);
   }
}
