<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReconciliationController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        $paymentMethods = [
            'Mpesa' => 'PaymentMethods.Mpesa',
            'Cash' => 'PaymentMethods.Cash',
            'Cheque' => 'PaymentMethods.Cheque',
        ];

        $reconciliationData = [];

        foreach ($paymentMethods as $method => $paymentMethod) {
            $totalAmount = DB::table('order_payments')
                ->where('payment_method', $paymentMethod)
                ->where('isReconcile', 'false')
                ->where('user_id', $user_id)
                ->sum('amount');

            $reconciliationData[$method] = $totalAmount;
        }

        return response()->json([
            "success" => true,
            "message" => "Total Amount Expected",
            "reconciliation_data" => $reconciliationData,
        ]);
    }
}
