<?php

namespace App\Http\Controllers\Api\total;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\customers;
use App\Models\Subarea;
use App\Models\Subregion;
use App\Models\zone;

class RegionalFilter extends Controller
{

   /**
    *
   
    *
    * @param Request $request
    * @return void
    */
   public function filterRegionalCustomers(Request $request)
   {
      $route_code = $request->user()->route_code;
      $data = customers::where('region_id', $route_code)->get();
      return response()->json(
         [
            'status' => 200,
            'message' => "Customers filtered by region",
            'data' => $data
         ],
         200
      );
   }
}
