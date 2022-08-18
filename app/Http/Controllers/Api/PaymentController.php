<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\order_payments as Payment;

class PaymentController extends Controller
{

    public function index(Request $request)
    {

        $orderID = $request->get('orderID');
        $checking_code = DB::table('orders')->where('order_code', $orderID)->first();
        $code =$checking_code->checkin_code;
        $amount = $request->get('amount');
        $transactionID = $request->get('transactionID');
        $paymentMethod = $request->get('paymentMethod');
        $balance = $checking_code->balance - $amount;

   Payment::where('order_id', '=', $orderID)
    ->update([
            'amount'=>$amount,
            'balance'=>$balance,
            'payment_date'=>now(),
            'payment_method'=>$paymentMethod,
            'reference_number'=>$transactionID,
            'updated_at'=>now()
    ]);
    
  (string) $payment_status = $balance ==0 ? "PAID": "PARTIAL PAID"; ;

  Orders::where('order_code', '=', $orderID)
    ->update([
            'balance'=>$balance,
            'order_status'=>'DELIVERED',
            'payment_status'=> $payment_status,
            'updated_at'=>now()
    ]);


        return response()->json([
            "success" => true,
            "message" => "Successfully",
            "Result" => $orderID

        ]);
    }
 // $checking_code = DB::select('SELECT `checkin_code` FROM `orders` WHERE `order_code`=?', [$orderID]);
        // $data =$checking_code;
       // $total = DB::select('SELECT `total_amount` FROM `order_cart` WHERE `checkin_code`=?', [$code]);
        //$userID = $request->user()->id;

    //     $query = DB::insert('INSERT INTO `order_payments`(
    //     `amount`,
    //     `balance`,
    //     `payment_date`,
    //     `payment_method`,
    //     `reference_number`,
    //     `order_id`,
    //     `user_id`,
    //     `created_at`,
    //     `updated_at`
    // )
    // VALUES(?,?,?,?,?,?,?,?,?', [$amount, $balance, now(), $paymentMethod, 
    //                            $transactionID, $orderID, $userID, now(), now()]);

}
