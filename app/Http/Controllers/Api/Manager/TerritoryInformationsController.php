<?php

namespace App\Http\Controllers\Api\Manager;

use App\Helpers\Sales;
use App\Http\Controllers\Controller;
use App\Models\Territory;
use Illuminate\Http\Request;

class TerritoryInformationsController extends Controller
{
   public function getAllTerritories(Request $request)
   {
      // @foreach($territories as $territory)
      // <li data-jstree='{"icon" : "fa fa-dot-folder"}'>
      //       {{  $territory->name  }}
      //       <ul>
      //          @foreach(Sales::child_territory($territory->code) as $child)
      //             <li data-jstree='{"icon" : "fa fa-dot-circle"}'>{{ $child->name }}</li>
      //             <ul>
      //                @foreach(Sales::child_territory($child->code) as $chil2)
      //                   <li data-jstree='{"icon" : "fa fa-dot-circle"}'>{!! $chil2->name !!}</li>
      //                @endforeach
      //             </ul>
      //          @endforeach
      //       </ul>
      //    </li>
      // @endforeach

      $data = [];
      $territories =  Territory::where('parent_code', 1)->get();
      foreach ($territories as $key1 => $territory) {
         $data[$key1]["level 0"] = $territory->name;
         foreach (Sales::child_territory($territory->code) as $key2 => $child) {
            $data[$key1][$key2]["level 1"] = $child->name;
            foreach (Sales::child_territory($child->code) as $key3 => $child2) {
               $data[$key1][$key2][$key3]["level 2"] = $child2->name;
            }
         }
      }
      return response()->json([
         "success" => true,
         "status" => 200,
         "data" => $data,
      ]);
   }
}