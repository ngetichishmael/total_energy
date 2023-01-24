<?php

namespace App\Http\Controllers\Api\total;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\customers;
use App\Models\Subregion;
use App\Models\zone;

class RegionalFilter extends Controller
{

   /**
    *
    ALTER TABLE `customers` ADD `region_id` INT(255) NULL
    DEFAULT NULL AFTER `route_code`, ADD `subregion_id` INT(255)
    NULL DEFAULT NULL AFTER `region_id`, ADD `zone_id` INT(255) NULL
    DEFAULT NULL AFTER `subregion_id`, ADD `unit_id` INT(255) NULL DEFAULT NULL AFTER `zone_id`;
    *
    * @param Request $request
    * @return void
    */
   public function filterRegionalCustomers(Request $request)
   {
      $route_code = $request->user()->route_code;
      $data = array();
      $regions = Region::where('primary_key',  $route_code)->first();
      $subregion = Subregion::where('primary_key',  $route_code)->first();
      $zone = zone::where('primary_key',  $route_code)->first();

      if ($regions) {
         $data = customers::where('region_id', $regions->id)->get();
      } else if ($subregion) {
         $data = customers::where('region_id', $subregion->Region->id)->get();
      } else if ($zone) {
         $data = customers::where('region_id', $zone->Subregion->Region->id)->get();
      }
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