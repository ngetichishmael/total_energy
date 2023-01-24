<?php

namespace App\Http\Controllers\Api\total;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subregion;
use App\Models\zone;

class RegionalFilter extends Controller
{
   public function filterRegionalCustomers(Request $request)
   {
      $route_code = $request->user()->route_code;
      $data = null;
      $regions = Region::where('route_code',  $route_code)->get();
      $subregion = Subregion::where('route_code',  $route_code)->get();
      $zones = zone::where('route_code',  $route_code)->get();

      if ($regions) {
         $ids=zones::whereId($region->Subregion->Zones->id)
      }
   }
}