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
      $data = Region::with('Subregion.Area')->get();
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
      // $data = Relationship::where('has_children', '0')->get();
      $data = Region::with('Subregion.Area')->get();
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
