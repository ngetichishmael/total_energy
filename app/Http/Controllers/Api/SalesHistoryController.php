<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\customer\checkin;
use App\Models\customer\customers;
use Illuminate\Support\Facades\DB;

class SalesHistoryController extends Controller
{
    public function index(Request $request, $shopID)
    {
        $checking = checkin::where('customer_id', $shopID)->first();
        $user_code = $request->user()->user_code;
        $customerID = $request->customer_id;

        $query = DB::select('SELECT
        `customerID`,
        `user_code`,
        `order_code`,
        `price_total`,
        `order_status`,
        `payment_status`,
        `checkin_code`,
        `order_type`,
        `created_at`
    FROM
        `orders` where `user_code`=? AND `customerID`=?', [$user_code, $shopID]);

        return response()->json([
            "success" => true,
            "message" => "Sales / Van Sales",
            "Data" => $query
        ]);
    }
}
