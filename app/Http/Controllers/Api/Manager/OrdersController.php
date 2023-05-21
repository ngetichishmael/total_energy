<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
   public function allOrders(Request $request)
   {

      return response()->json([
         'status' => 200,
         'success' => true,
         'message' => 'Orders with the Order items, the Sales associate, and the customer',
         'Data' => Orders::with('OrderItem', 'User', 'Customer','Payments','OrderItems')->get(),
      ]);
   }
}
