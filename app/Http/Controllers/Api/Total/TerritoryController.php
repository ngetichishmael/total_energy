<?php

namespace App\Http\Controllers\Api\Total;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Relationship;
use Illuminate\Http\Request;

class TerritoryController extends Controller
{
   public function terriory(Request $request)
   {
      $regionId = $request->user()->route_code;
      $data = Region::with('Subregion.Area')->whereId($regionId)->get();
      return response()->json(
         [
            'status' => 200,
            'message' => 'Regional Data',
            'data' => $data,
         ],
         200
      );
   }

   public function routes(Request $request)
   {
      $regionId = $request->user()->route_code;
      $data = Region::with('Subregion.Area')->whereId($regionId)->get();
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
