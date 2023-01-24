<?php

namespace App\Http\Controllers\Api\Total;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class TerritoryController extends Controller
{
   public function terriory()
   {
      return response()->json(
         [
            'status' => 200,
            'message' => 'Nested Territory ',
            'data' => Region::with('Subregion.Zones')->get(),
         ],
         200
      );
   }
}
