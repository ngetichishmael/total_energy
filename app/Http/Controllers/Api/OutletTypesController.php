<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OutletType;
use Illuminate\Http\Request;

class OutletTypesController extends Controller
{
   public function getOutletTypes(Request $request)
   {

      return response()->json([
         "success" => true,
         "message" => "Data posted successfully",
         "outlets" => OutletType::where('business_code', $request->user()->business_code)->get()
      ]);
   }
}
