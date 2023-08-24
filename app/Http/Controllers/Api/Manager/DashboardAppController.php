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
       $data = [
           'status' => 200,
           'success' => true,
           'active_users' => [
               'today' => $this->getCheckinCount('today'),
               'yesterday' => $this->getCheckinCount('yesterday'),
               'this_week' => $this->getCheckinCount('currentWeek'),
               'last_week' => $this->getCheckinCount('lastWeek'),
               'month' => $this->getCheckinCount('currentMonth'),
               'last_month' => $this->getCheckinCount('lastMonth'),
               'user_count' => User::count(),
           ],
           'new_customers_visits' => [
               'today' => $this->getCheckinCount('today', 'customer_id'),
               'yesterday' => $this->getCheckinCount('yesterday', 'customer_id'),
               'this_week' => $this->getCheckinCount('currentWeek', 'customer_id'),
               'last_week' => $this->getCheckinCount('lastWeek', 'customer_id'),
               'month' => $this->getCheckinCount('currentMonth', 'customer_id'),
               'last_month' => $this->getCheckinCount('lastMonth', 'customer_id'),
           ],
           'pending_approval' => allocations::where('status', 'Waiting acceptance')->count(),
           'completed_forms' => survey::where('status', 'Completed')->count(),
       ];
   
       return response()->json($data, 200);
   }
   
   private function getCheckinCount($period, $groupColumn = 'user_code')
   {
       return User::joinSub(
           checkin::select($groupColumn)->$period()->groupBy($groupColumn),
           'customer_checkin',
           function ($join) {
               $join->on('users.user_code', '=', 'customer_checkin.user_code');
           }
       )->count();
   }
   

   // public function dashboard(Request $request)
   // {

   //     //Active Users
   //     $checking = checkin::select('user_code')->groupBy('user_code');
   //     $all = User::joinSub($checking, 'customer_checkin', function ($join) {
   //        $join->on('users.user_code', '=', 'customer_checkin.user_code');
   //     })->count();
   //     $checking = checkin::select('user_code')->today()->groupBy('user_code');

   //     $today = User::joinSub($checking, 'customer_checkin', function ($join) {
   //        $join->on('users.user_code', '=', 'customer_checkin.user_code');
   //     })->count();

   //     $checking = checkin::select('user_code')->yesterday()->groupBy('user_code');
   //     $yesterday = User::joinSub($checking, 'customer_checkin', function ($join) {
   //        $join->on('users.user_code', '=', 'customer_checkin.user_code');
   //     })->count();

   //     $checking = checkin::select('user_code')->currentWeek()->groupBy('user_code');
   //     $this_week = User::joinSub($checking, 'customer_checkin', function ($join) {
   //        $join->on('users.user_code', '=', 'customer_checkin.user_code');
   //     })->count();

   //     $checking = checkin::select('user_code')->lastWeek()->groupBy('user_code');
   //     $last_week = User::joinSub($checking, 'customer_checkin', function ($join) {
   //        $join->on('users.user_code', '=', 'customer_checkin.user_code');
   //     })->count();

   //     $checking = checkin::select('user_code')->currentMonth()->groupBy('user_code');
   //     $month = User::joinSub($checking, 'customer_checkin', function ($join) {
   //        $join->on('users.user_code', '=', 'customer_checkin.user_code');
   //     })->count();

   //     $checking = checkin::select('user_code')->lastMonth()->groupBy('user_code');
   //     $last_month = User::joinSub($checking, 'customer_checkin', function ($join) {
   //        $join->on('users.user_code', '=', 'customer_checkin.user_code');
   //     })->count();

   //     $data = [
   //       'status' => 200,
   //       'success' => true,
   //       'active_users' => [
   //          'today' => $today,
   //          'yesterday' => $yesterday,
   //          'this_week' => $this_week,
   //          'last_week' => $last_week,
   //          'month' => $month,
   //          'last_month' => $last_month,
   //          "user_count" => $all,
   //       ],
   //       'new_customers_visits' => [
   //          'today' => checkin::select('customer_id', 'updated_at')->today()->groupBy('customer_id')->count(),
   //          'yesterday' => checkin::select('customer_id', 'updated_at')->yesterday()->groupBy('customer_id')->count(),
   //          'this_week' => checkin::select('customer_id', 'updated_at')->currentWeek()->groupBy('customer_id')->count(),
   //          'last_week' => checkin::select('customer_id', 'updated_at')->lastWeek()->groupBy('customer_id')->count(),
   //          'month' => checkin::select('customer_id', 'updated_at')->currentMonth()->groupBy('customer_id')->count(),
   //          'last_month' => checkin::select('customer_id', 'updated_at')->lastMonth()->groupBy('customer_id')->count(),
   //       ],
   //       // 'new_customers_added' => [
   //       //    'today' => customers::today()->count(),
   //       //    'yesterday' => customers::yesterday()->count(),
   //       //    'this_week' => customers::currentWeek()->count(),
   //       //    'last_week' => customers::lastWeek()->count(),
   //       //    'month' => customers::currentMonth()->count(),
   //       //    'last_month' => customers::lastMonth()->count(),
   //       // ],

   //       // 'pre_sales_value' => [
   //       //    'today' => Orders::where('order_type', 'Pre Order')->today()->count(),
   //       //    'yesterday' => Orders::where('order_type', 'Pre Order')->yesterday()->count(),
   //       //    'this_week' => Orders::where('order_type', 'Pre Order')->currentWeek()->count(),
   //       //    'last_week' => Orders::where('order_type', 'Pre Order')->lastWeek()->count(),
   //       //    'month' => Orders::where('order_type', 'Pre Order')->currentMonth()->count(),
   //       //    'last_month' => Orders::where('order_type', 'Pre Order')->lastMonth()->count(),
   //       // ],
   //       // 'existing_customer_visit' => [
   //       //    'today' => customers::today()->count(),
   //       //    'yesterday' => customers::yesterday()->count(),
   //       //    'this_week' => customers::currentWeek()->count(),
   //       //    'last_week' => customers::lastWeek()->count(),
   //       //    'month' => customers::currentMonth()->count(),
   //       //    'last_month' => customers::lastMonth()->count(),
   //       // ],
   //       'pending_approval' => allocations::where('status', 'Waiting acceptance')->count(),
   //       'completed_forms' => survey::where('status', 'Completed')->count(),

   //       // 'custom_data' => $this->custom($request)->getData(),
   //    ];
   //    return response()->json($data, 200);
   // }

   public function custom(Request $request)
   {
      $start_date = $request->start_date;
      $end_date = $request->end_date;
      $checking = checkin::select('user_code')->period($start_date, $end_date)->groupBy('user_code');
      $today = User::joinSub($checking, 'customer_checkin', function ($join) {
         $join->on('users.user_code', '=', 'customer_checkin.user_code');
      })->count();
      $data = [
//         'status' => 200,
//         'success' => true,
         'active_users' => $today,
         'new_customers_visits' => checkin::select('customer_id', 'updated_at')->period($start_date, $end_date)->groupBy('customer_id')->count(),
         'new_customers_added' =>  customers::period($start_date, $end_date)->count(),
         'pre_sales_value' => Orders::where('order_type', 'Pre Order')->period($start_date, $end_date)->count(),
         'existing_customer_visit' => customers::period($start_date, $end_date)->count(),
         'pending_approval' => allocations::where('status', 'Waiting acceptance')->period($start_date, $end_date)->count(),
         'completed_forms' => survey::where('status', 'Completed')->period($start_date, $end_date)->count(),
      ];
      return response()->json($data, 200);

   }

}