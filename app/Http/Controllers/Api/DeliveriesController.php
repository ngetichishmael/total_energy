<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Orders;
use Illuminate\Http\Request;

class DeliveriesController extends Controller
{
   public function getDeliveries(Request $request)
   {
      $user_code = $request->user()->user_code;
      $data = Orders::with('OrderItems', 'Customer')
         ->where('user_code', $user_code)
         ->get();
      $deliveries = Delivery::with(['DeliveryItems', 'Customer'])
         ->where('allocated', $user_code)
         ->get();
      return response()->json([
         "success" => true,
         "status" => 200,
         "Message" => "All Deliveries with their orders",
         "deliveries" => $deliveries,
      ]);
   }
}
