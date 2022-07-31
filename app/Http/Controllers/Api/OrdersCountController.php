<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders as ModelsOrders;
use Illuminate\Http\Request;
class OrdersCountController extends Controller
{
    public function index(){

        
        
        $countWeek= ModelsOrders::whereBetween('delivery_date',[
            now()->startOfWeek(),now()->endOfWeek()
        ])
        ->where('customerID',auth()->user()->id)
        ->count();

        // SELECT COUNT(*) AS YEAR FROM `orders` WHERE YEAR(`orders`.`delivery_date`)=YEAR(NOW())
        // $users = DB::table('users')
        // ->whereYear('created_at', '2016')
        // ->get();
        $countMonth=ModelsOrders::whereMonth('delivery_date',now())
        ->where('customerID',auth()->user()->id)
        ->count();
        $countYear=ModelsOrders::whereYear('delivery_date',now())
        ->where('customerID',auth()->user()->id)
        ->count();

        $result = [
            "Count Year"=>$countWeek,
            "Count Month"=>$countMonth,
            "Count Week"=>$countYear,
        ];

        return $result;
    }
}
 