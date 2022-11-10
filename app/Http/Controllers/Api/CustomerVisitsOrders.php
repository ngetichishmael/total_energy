<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\customer\checkin;
use App\Models\Orders;
use Illuminate\Http\Request;

class CustomerVisitsOrders extends Controller
{
    public function getCounts(Request $request,$customerID)
    {
      $checkingCount = checkin::where('customer_id', $customerID)
      ->where('user_code', $request->user()->user_code)
      ->count();
   $orderCount = Orders::where('customerID', $customerID)
      ->where('user_code', $request->user()->user_code)
      ->count();
      return response()->json([
         "success" => true,
         "message" => "Total Counts for Orders and Checkings",
         "checkingCount" => $checkingCount,
         "orderCount" => $orderCount,
      ]);
    }
}
