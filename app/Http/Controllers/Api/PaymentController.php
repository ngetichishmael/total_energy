<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MKOOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\order_payments;
use App\Models\Orders;

class PaymentController extends Controller
{

   public function index(Request $request)
   {
      $route_code = $request->user()->route_code;
      $user_code = $request->user()->user_code;
      $orderID = $request->get('orderID');
      $checking_code = DB::table('orders')->where('order_code', $orderID)->first();
      $amount = $request->get('amount');
      $transactionID = $request->get('transactionID');
      $paymentMethod = $request->get('paymentMethod');
      $balance = $checking_code->balance - $amount;
      $ID = $request->user()->id;

      order_payments::create([
         'amount' => $amount,
         'balance' => $balance,
         'payment_date' => now(),
         'payment_method' => $paymentMethod,
         'reference_number' => $transactionID,
         'order_id' => $orderID,
         'user_id' => $ID,
      ]);

      (string) $payment_status = $balance == 0 ? "PAID" : "PARTIAL PAID";

      Orders::where('order_code', '=', $orderID)
         ->update([
            'balance' => $balance,
            'payment_status' => $payment_status,
            'updated_at' => now()
         ]);
      DB::table('sales_targets')
         ->where('user_code', $user_code)
         ->increment('AchievedSalesTarget', $amount);

      if ($route_code === 2) {
         (new MKOOrder())($request);
      }
      return response()->json([
         "success" => true,
         "message" => "Successfully",
         "Result" => $orderID

      ]);
   }
}
