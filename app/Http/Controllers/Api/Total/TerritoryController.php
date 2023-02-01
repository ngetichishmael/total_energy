<?php

namespace App\Http\Controllers\Api\Total;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Subregion;
use App\Models\zone;
use Illuminate\Http\Request;

class TerritoryController extends Controller
{
   public function terriory(Request $request)
   {
      $route_code = $request->user()->route_code;
      $data = array();
      $regions = Region::where('primary_key',  $route_code)->first();
      $subregion = Subregion::where('primary_key',  $route_code)->first();
      $zone = zone::where('primary_key',  $route_code)->first();

      if ($regions) {
         $data = Region::with('Subregion.Zones')->where('region_id', $regions->id)->get();
      } else if ($subregion) {
         $data = Region::with('Subregion.Zones')->where('region_id', $subregion->Region->id)->get();
      } else if ($zone) {
         $data = Region::with('Subregion.Zones')->where('region_id', $zone->Subregion->Region->id)->get();
      }
      return response()->json(
         [
            'status' => 200,
            'message' => 'Nested Territory ',
            'data' => $data,
         ],
         200
      );
   }
}