<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders as ModelsOrders;
use Illuminate\Http\Request;


class SalesMadeController extends Controller
{
    //    
    public function index(Request $request){
        $user=$request->user()->id;
// 
//     $price = DB::table('orders')
//                 ->where('finalized', 1)
//                 ->avg('price');
// 

        $result= ModelsOrders::where('customerID',$user)
        ->sum('price_total');
        
        return response()->json([
            "success" => true,
            "message" => "Total Made",
            "TotalSales" => $result,
         ]);
         //15430
    }
}
