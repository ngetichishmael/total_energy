<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Models\customer\checkin;
use App\Models\customer\customers;
use App\Models\inventory\allocations;
use App\Models\Orders;
use App\Models\survey\survey;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardAppController extends Controller
{
   public function dashboard(Request $request)
   {

      //Active Users
      $checking = checkin::select('user_code')
         ->where('updated_at', Carbon::today())
         ->groupBy('user_code');
      $today = User::joinSub($checking, 'customer_checkin', function ($join) {
         $join->on('users.user_code', '=', 'customer_checkin.user_code');
      })->count();
      $checking = checkin::select('user_code')
         ->where('updated_at', Carbon::yesterday())
         ->groupBy('user_code');
      $yesterday = User::joinSub($checking, 'customer_checkin', function ($join) {
         $join->on('users.user_code', '=', 'customer_checkin.user_code');
      })->count();
      $checking = checkin::select('user_code')
         ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
         ->groupBy('user_code');
      $this_week = User::joinSub($checking, 'customer_checkin', function ($join) {
         $join->on('users.user_code', '=', 'customer_checkin.user_code');
      })->count();
      $checking = checkin::select('user_code')
         ->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
         ->groupBy('user_code');
      $month = User::joinSub($checking, 'customer_checkin', function ($join) {
         $join->on('users.user_code', '=', 'customer_checkin.user_code');
      })->count();
      $checking = checkin::select('user_code')
         ->where('updated_at', Carbon::today())
         ->groupBy('user_code');

      $data = [
         'status' => 200,
         'success' => true,
         'active_users' => [
            'today' => $today,
            'yesterday' => $yesterday,
            'this_week' => $this_week,
            'month' => $month,
            'custom' => 'Not Implemented'
         ],
         'new_customers_visits' => [
            'today' => checkin::select('customer_id', 'updated_at')->where('updated_at', Carbon::today())->groupBy('customer_id')->groupBy('customer_id')->count(),
            'yesterday' => checkin::select('customer_id', 'updated_at')->where('updated_at', Carbon::yesterday())->groupBy('customer_id')->count(),
            'this_week' => checkin::select('customer_id', 'updated_at')->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->groupBy('customer_id')->count(),
            'month' => checkin::select('customer_id', 'updated_at')->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->groupBy('customer_id')->count(),
            'custom' => "not implemented"
         ],
         'new_customers_added' => [
            'today' => customers::where('updated_at', Carbon::today())->count(),
            'yesterday' => customers::where('updated_at', Carbon::yesterday())->count(),
            'this_week' => customers::whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'month' => customers::whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count(),
            'custom' => "not implemented"
         ],
         'pre_sales_value' => [
            'today' => Orders::where('order_type', 'Pre Order')->where('updated_at', Carbon::today())->count(),
            'yesterday' => Orders::where('order_type', 'Pre Order')->where('updated_at', Carbon::yesterday())->count(),
            'this_week' => Orders::where('order_type', 'Pre Order')->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'month' => Orders::where('order_type', 'Pre Order')->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count(),
            'custom' => "not implemented"
         ],
         'existing_customer_visit' => [
            'today' => customers::where('updated_at', Carbon::today())->count(),
            'yesterday' => customers::where('updated_at', Carbon::yesterday())->count(),
            'this_week' => customers::whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'month' => customers::whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count(),
            'custom' => "Remind me we discuss this. There some errors in design. There is a conflict in logic"
         ],
         'pending_approval' => allocations::where('status', 'Waiting acceptance')->count(),
         'completed_forms' => survey::where('status', 'Completed')->count(),
      ];
      return response()->json($data, 200);
   }
}