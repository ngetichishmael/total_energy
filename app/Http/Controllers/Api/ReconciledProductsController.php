<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReconciledProducts as ReconciledProducts;
use Illuminate\Http\Request;

class ReconciledProductsController extends Controller
{
    public function index(Request $request)
    {
        $usercode = $request->user()->user_code;
        $request= $request->all();
        array_pop($request);
        info($request);
        foreach ($request as $data){
            $reconciled_products= new ReconciledProducts();
            $reconciled_products->productID = $data['productID'];
            info($data["productID"]);
            $reconciled_products->amount = $data['amount'];
            $reconciled_products->supplierID = $data['supplierID'];
            $reconciled_products->userCode  = $usercode;
            $reconciled_products->save();
        }

        return response()->json([
            "success" => true,
            "message" => "All products were successfully reconciled",
            "Result"    => "Successful"
        ]);
    }

}
