<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
   public function getReports(Request $request)
   {
      $user_code = $request->user()->user_code;
      // $countWeek = ModelsCustomers::whereBetween('updated_at', [
      //    now()->startOfWeek(), now()->endOfWeek()
      // ])->count();

      // $countMonth = ModelsCustomers::whereMonth('created_at', now())
      //    ->count();

      // $countYear = ModelsCustomers::whereYear('updated_at', now())
      //    ->count();
      $countOrders=Orders::where('user_code',$user_code);
   }
}
