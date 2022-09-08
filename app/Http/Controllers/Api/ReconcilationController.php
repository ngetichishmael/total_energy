<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReconcilationController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $mpesa= DB::select('SELECT
        SUM(`amount`)
                FROM
                    `order_payments`
                WHERE
                    `order_payments`.`payment_method` =? AND `order_payments`.`user_id`=?',['PaymentMethods.Mpesa',$user_id]);
        $cash= DB::select('SELECT
        SUM(`amount`)
                FROM
                    `order_payments`
                WHERE
                    `order_payments`.`payment_method` =? AND `order_payments`.`user_id`=?',['PaymentMethods.Cash',$user_id]);
        $cheque= DB::select('SELECT
        SUM(`amount`)
                FROM
                    `order_payments`
                WHERE
                    `order_payments`.`payment_method` =? AND `order_payments`.`user_id`=?',['PaymentMethods.Cheque',$user_id]);

return response()->json([
    "success" => true,
    "message" => "Total Amount Expected",
    "Data" => $mpesa,
    "Data" => $cash,
    "Data" => $cheque
]);
    }
}
