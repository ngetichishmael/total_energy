<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MpesaPayment;
use App\Http\Controllers\Controller;
use App\Models\MpesaPayment as ModelsMpesaPayment;
use Illuminate\Http\Request;

class STKPushController extends Controller
{
   public function index(Request $request)
   {
      $mpesaPayment = new MpesaPayment();
      $results = $mpesaPayment->stkPush(
         $request->customer_phone_number,
         $request->amount,
         route('mpesa.stkpush'),
         $request->orderID,
         'Payment for order ' . $request->orderID
      );
      info(json_encode($results));
      if ($results['response_code'] != null) {
         ModelsMpesaPayment::create([
            'account' => $request->orderID,
            'checkout_request_id' => $results['checkout_request_id'],
            'phone' => $request->customer_phone_number,
            'amount' => $request->amount,
            'purpose' => 'Payment for order ID ' . $request->orderID,
         ]);
         return response()->json(['data' => 'Payment is being processed.'], 200);
      }
      return response()->json(['data' => 'Payment is not being processed.'], 500);
   }
}
