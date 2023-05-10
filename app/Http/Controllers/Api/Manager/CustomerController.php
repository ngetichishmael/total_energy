<?php

namespace App\Http\Controllers\api\manager;

use App\Http\Controllers\Controller;
use App\Models\MKOCustomer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   public function getCustomers()
   {
      return response()->json([
         "success" => true,
         "status" => 200,
         "data" => User::where('account_type', 'Customer')->get(),
      ]);
   }
   public function searchExternalCustomer(Request $request)
   {
      $route_code = $request->user()->route_code;
      $search = '%' . $request->search . '%';

      $data = MKOCustomer::whereLike(['customer_name'], $search);

      switch ($route_code) {
         case 2:
            $data->where('source', 'odoo');
            break;
         case 1:
            $data->where('source', 'crystal');
            break;
         default:
            $data->where('sokoflow', 'odoo');
            break;
      }

      $data = $data->get();

      return response()->json([
         "success" => true,
         "status" => 200,
         "message" => "Search successful",
         "data" => $data,
      ]);
   }
}