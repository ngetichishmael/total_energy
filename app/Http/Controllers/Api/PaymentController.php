<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MKOOrder;
use App\Helpers\MpesaPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\customer\customers;
use App\Models\MpesaPayment as ModelsMpesaPayment;
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
      $customer_phone_number = customers::whereId($checking_code->customerID)->pluck('phone_number')->implode('');
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
      } else {
         $mpesaPayment = new MpesaPayment();
         $results = $mpesaPayment->stkPush(
            $customer_phone_number,
            $amount,
            route('mpesa.stkpush'),
            $orderID,
            'Payment for order ' . $orderID
         );
         if ($results['response_code'] != null) {
            ModelsMpesaPayment::create([
               'account' => $orderID,
               'checkout_request_id' => $results['checkout_request_id'],
               'phone' => $customer_phone_number,
               'amount' => $amount,
               'purpose' => 'Payment for order ID ' . $orderID,
            ]);

            // return response()->json(['data' => 'Payment is being processed.'], 200);
         }
      }

      return response()->json([
         "success" => true,
         "message" => "Successfully",
         "Result" => $orderID

      ]);
   }
   public function stkPushCallback(Request $request)
   {
      $callbackJSONData = file_get_contents('php://input');
      $callbackData = json_decode($callbackJSONData);

      info($callbackJSONData);

      $result_code = $callbackData->Body->stkCallback->ResultCode;
      // $result_desc = $callbackData->Body->stkCallback->ResultDesc;
      $merchant_request_id = $callbackData->Body->stkCallback->MerchantRequestID;
      $checkout_request_id = $callbackData->Body->stkCallback->CheckoutRequestID;
      $amount = $callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value;
      $mpesa_receipt_number = $callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
      // $transaction_date = $callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
      // $phone_number = $callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;


      $result = [
         // "result_desc" => $result_desc,
         "result_code" => $result_code,
         "merchant_request_id" => $merchant_request_id,
         "checkout_request_id" => $checkout_request_id,
         "amount" => $amount,
         "mpesa_receipt_number" => $mpesa_receipt_number,
         // "phone" => $phone_number,
         // "transaction_date" => Carbon::parse($transaction_date)->toDateTimeString()
      ];

      if ($result['result_code'] == 0) {

         //  SendSms::dispatchAfterResponse($order->service->vendor->company_phone_number, 'The client completed the payment for the order '.$order->order_id);
      }
   }
}
