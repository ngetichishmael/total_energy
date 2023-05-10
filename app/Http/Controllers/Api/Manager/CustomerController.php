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
      $search = '%' . $request->search . '%';
      $data =  MKOCustomer::whereLike(['customer_name'], $search)->get();
      return response()->json([
         "success"  => true,
         "status"   => 200,
         "message"  => "Search successful ",
         "data" => $data,
      ]);
   }
}
