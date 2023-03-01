<?php

namespace App\Http\Controllers\Api\Total;

use App\Http\Controllers\Controller;
use App\Models\Relationship;
use Illuminate\Http\Request;

class TerritoryController extends Controller
{
   public function terriory(Request $request)
   {
      // $route_code = $request->user()->route_code;
      // $data = array();
      // $regions = Region::where('primary_key',  $route_code)->first();
      // $subregion = Subregion::where('primary_key',  $route_code)->first();
      // $zone = zone::where('primary_key',  $route_code)->first();

      // if ($regions) {
      //    $data = Region::with('Subregion.Zones')->whereId($regions->id)->get();
      // } else if ($subregion) {
      //    $data = Region::with('Subregion.Zones')->whereId($subregion->Region->id)->get();
      // } else if ($zone) {
      //    $data = Region::with('Subregion.Zones')->whereId($zone->Subregion->Region->id)->get();
      // }
      $data = Relationship::where('has_children', '0')->get();
      return response()->json(
         [
            'status' => 200,
            'message' => 'Regional Data',
            'data' => $data,
         ],
         200
      );
   }

   public function routes()
   {
      $data = Relationship::where('has_children', '0')->get();
      return response()->json(
         [
            'status' => 200,
            'message' => 'Regional Data',
            'data' => $data,
         ],
         200
      );
   }
}
