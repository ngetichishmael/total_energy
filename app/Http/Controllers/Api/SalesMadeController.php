<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders as ModelsOrders;

class SalesMadeController extends Controller
{
    //    
    public function index(){
// 
//     $price = DB::table('orders')
//                 ->where('finalized', 1)
//                 ->avg('price');
// 

        $result= ModelsOrders::where('customerID',auth()->user()->id)
        ->sum('price_total');
        return response()->json([
            "success" => true,
            "message" => "Total Made ",
            "Total" => $result,
         ]);
    }
}
