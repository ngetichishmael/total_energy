<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\inventory\items;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class StockLiftController extends Controller
{
    public function index(Request $request){
        $user_code = $request->user()->user_code;
        $business_code = $request->user()->business_code;
        $random = Str::random(20);
        $request = $request->all();
        array_pop($request);
        foreach ($request as $value) {
        $checkInCart = items::where('product_code', $value["productID"])->count();
        if ($checkInCart > 0) {
            DB::update('UPDATE
        inventory_allocated_items
    SET
        current_qty =current_qty+?,
        updated_at = ?
    WHERE
        product_code= ?',[$value["qty"], now(), $value["productID"]]);
        } else {
           
            $cart = new items();
            $cart->business_code = $business_code;
            $cart->allocation_code = $random;
            $cart->product_code = $value["qty"];
            $cart->current_qty=  $value["productID"];
            $cart->allocated_qty=  $value["productID"];
            $cart->returned_qty = $user_code;
            $cart->created_by = $user_code;
            $cart->updated_by = $user_code;
            $cart->created_at = now();
            $cart->updated_at = now();
            $cart->save();
        }
        
        
        return response()->json([
            "success" => true,
            "message" => "StockLift Successfully added",
            "data"    => true
        ]);
    }
}
}