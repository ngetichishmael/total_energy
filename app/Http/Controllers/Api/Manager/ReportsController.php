<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Models\customer\checkin;
use App\Models\Orders;
use App\Models\User;
use App\Models\Region;
use App\Models\Routes;
use App\Models\Subregion;
use App\Models\AssignedRegion;
use App\Models\Area;
use App\Models\customer\customers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{

   public function reports(Request $request)
   {

      $todayDate = Carbon::today()->toDateString();

          // Calculate date ranges
          $todayStart = Carbon::now()->startOfDay();
          $todayEnd = Carbon::now()->endOfDay();
          $yesterdayStart = Carbon::yesterday()->startOfDay();
          $yesterdayEnd = Carbon::yesterday()->endOfDay();
          $thisWeekStart = Carbon::now()->startOfWeek();
          $thisWeekEnd = Carbon::now()->endOfWeek();
          $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
          $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
          $currentMonthStart = Carbon::now()->startOfMonth();
          $currentMonthEnd = Carbon::now()->endOfMonth();
          $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
          $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
      
          $loggedInUserId = auth()->user()->id;


            // Get the authenticated user
            $user = Auth::user();
        
            // Retrieve the user's assigned regions
            $assignedRegions = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id');
            
            // Get the IDs of customers assigned to the assigned regions
            $assignedCustomerIds = customers::whereHas('area.subregion.region', function ($query) use ($assignedRegions) {
                $query->whereIn('regions.id', $assignedRegions);
            })->pluck('id');


      //Active Users
      $checking = checkin::select('user_code')
      ->groupBy('user_code');
  
      $currentUserRouteCode = auth()->user()->route_code;
      $currentUserCode = auth()->user()->user_code;
      
      $all = User::where('route_code', $currentUserRouteCode)
            ->joinSub($checking, 'customer_checkin', function ($join) {
               $join->on('users.user_code', '=', 'customer_checkin.user_code');
            })
            ->where('users.user_code', '!=', $currentUserCode) // Exclude the logged-in user
            ->count();
      
 

      $today = User::where('route_code', auth()->user()->route_code)->joinSub(
         checkin::select('user_code')
             ->whereBetween('created_at', [$todayStart, $todayEnd])
             ->groupBy('user_code'),
         'customer_checkin',
         function ($join) {
             $join->on('users.user_code', '=', 'customer_checkin.user_code');
         }
     )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
     ->distinct('users.id')->count();

      $yesterday = User::where('route_code', auth()->user()->route_code)->joinSub(
            checkin::select('user_code')
                ->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
                ->groupBy('user_code'),
            'customer_checkin',
            function ($join) {
                $join->on('users.user_code', '=', 'customer_checkin.user_code');
            }
        )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
        ->distinct('users.id')->count();

 
      $this_week =  User::where('route_code', auth()->user()->route_code)->joinSub(
               checkin::select('user_code')
                  ->whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])
                  ->groupBy('user_code'),
               'customer_checkin',
               function ($join) {
                  $join->on('users.user_code', '=', 'customer_checkin.user_code');
               }
         )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
         ->distinct('users.id')->count();
         
         

      $last_week = User::where('route_code', auth()->user()->route_code)->joinSub(
         checkin::select('user_code')
             ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
             ->groupBy('user_code'),
         'customer_checkin',
         function ($join) {
             $join->on('users.user_code', '=', 'customer_checkin.user_code');
         }
     )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
     ->distinct('users.id')->count();

      $this_month = User::where('route_code', auth()->user()->route_code)->joinSub(
         checkin::select('user_code')
             ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
             ->groupBy('user_code'),
         'customer_checkin',
         function ($join) {
             $join->on('users.user_code', '=', 'customer_checkin.user_code');
         }
     )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
     ->distinct('users.id')->count();


      $last_month =  User::where('route_code', auth()->user()->route_code)->joinSub(
         checkin::select('user_code')
             ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
             ->groupBy('user_code'),
         'customer_checkin',
         function ($join) {
             $join->on('users.user_code', '=', 'customer_checkin.user_code');
         }
     )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
     ->distinct('users.id')->count();

      (object)$data = [
         'status' => 200,
         'success' => true,
         "message" => "Reports data",
         "data" => (object)[
            'van_sales' => [
               'today' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Van sales')->whereDate('created_at', $todayDate)->sum('price_total'),
               'yesterday' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Van sales')->whereDate('created_at', Carbon::yesterday())->sum('price_total'),
               'this_week' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Van sales')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('price_total'),
               'last_week' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Van sales')->whereBetween('created_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])->sum('price_total'),
               'this_month' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Van sales')->whereMonth('created_at', Carbon::now()->month)->sum('price_total'),
               'last_month' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Van sales')->whereMonth('created_at', Carbon::now()->subMonth()->month)->sum('price_total'),
           ],
           'pre_orders' => [
               'today' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Pre Order')->whereDate('created_at', $todayDate)->sum('price_total'),
               'yesterday' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Pre Order')->whereDate('created_at', Carbon::yesterday())->sum('price_total'),
               'this_week' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Pre Order')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('price_total'),
               'last_week' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Pre Order')->whereBetween('created_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])->sum('price_total'),
               'this_month' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Pre Order')->whereMonth('created_at', Carbon::now()->month)->sum('price_total'),
               'last_month' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_type', 'Pre Order')->whereMonth('created_at', Carbon::now()->subMonth()->month)->sum('price_total'),
           ],
           'order_fulfillment' => [
               'today' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_status', 'DELIVERED')->whereDate('created_at', $todayDate)->sum('price_total'),
               'yesterday' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_status', 'DELIVERED')->whereDate('created_at', Carbon::yesterday())->sum('price_total'),
               'this_week' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_status', 'DELIVERED')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('price_total'),
               'last_week' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_status', 'DELIVERED')->whereBetween('created_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])->sum('price_total'),
               'this_month' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_status', 'DELIVERED')->whereMonth('created_at', Carbon::now()->month)->sum('price_total'),
               'last_month' => Orders::whereIn('customerID', $assignedCustomerIds)->where('order_status', 'DELIVERED')->whereMonth('created_at', Carbon::now()->subMonth()->month)->sum('price_total'),
           ],

            'active_users' => [
               'today' => $today,
               'yesterday' => $yesterday,
               'this_week' => $this_week,
               'last_week' => $last_week,
               'this_month' => $this_month,
               'last_month' => $last_month,
               "user_count" => $all,

            ],
            'customers_visits' => [
               'today' => checkin::whereIn('customer_id', $assignedCustomerIds)->select('customer_id', 'updated_at')
                   ->whereDate('updated_at', $todayDate)
                   ->groupBy('customer_id')
                   ->count(),
                   
               'yesterday' => checkin::whereIn('customer_id', $assignedCustomerIds)->select('customer_id', 'updated_at')
                   ->whereDate('updated_at', Carbon::yesterday())
                   ->groupBy('customer_id')
                   ->count(),
               'this_week' => checkin::whereIn('customer_id', $assignedCustomerIds)->select('customer_id', 'updated_at')
                   ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                   ->groupBy('customer_id')
                   ->count(),
               'last_week' => checkin::whereIn('customer_id', $assignedCustomerIds)->select('customer_id', 'updated_at')
                   ->whereBetween('updated_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])
                   ->groupBy('customer_id')
                   ->count(),
               'this_month' => checkin::whereIn('customer_id', $assignedCustomerIds)->select('customer_id', 'updated_at')
                   ->whereMonth('updated_at', Carbon::now()->month)
                   ->groupBy('customer_id')
                   ->count(),
               'last_month' => checkin::whereIn('customer_id', $assignedCustomerIds)->select('customer_id', 'updated_at')
                   ->whereMonth('updated_at', Carbon::now()->subMonth()->month)
                   ->groupBy('customer_id')
                   ->count(),
           ],
         ]
      ];
      return response()->json($data, 200);
   }


   
   public function vanSalesToday()
   {
       $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');
       $todayStart = Carbon::now()->startOfDay();
       $todayEnd = Carbon::now()->endOfDay();
       
       return response()->json([
           'status' => 200,
           'success' => true,
           'message' => "Van Sales for Today",
           'data' => Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
               $query->select('customers.id')
                   ->from('customers')
                   ->join('areas', 'customers.route_code', '=', 'areas.id')
                   ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                   ->whereIn('subregions.region_id', $assignedRegions);
           })
           ->where('order_type', 'Van sales')
           ->whereBetween('created_at', [$todayStart, $todayEnd])
           ->with(['OrderItems', 'Customer', 'User'])
           ->get(),
       ]);
   }
   
   public function vanSalesWeek()
   {
       $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');
       $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
       $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
       
       return response()->json([
           'status' => 200,
           'success' => true,
           'message' => "Van Sales for last week",
           'data' => Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
               $query->select('customers.id')
                   ->from('customers')
                   ->join('areas', 'customers.route_code', '=', 'areas.id')
                   ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                   ->whereIn('subregions.region_id', $assignedRegions);
           })
           ->where('order_type', 'Van sales')
           ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
           ->with(['OrderItems', 'Customer', 'User'])
           ->get(),
       ]);
   }
   
   public function vanSalesMonth()
   {
       $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');
       $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
       $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
       
       return response()->json([
           'status' => 200,
           'success' => true,
           'message' => "Van Sales for last month",
           'data' => Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
               $query->select('customers.id')
                   ->from('customers')
                   ->join('areas', 'customers.route_code', '=', 'areas.id')
                   ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                   ->whereIn('subregions.region_id', $assignedRegions);
           })
           ->where('order_type', 'Van sales')
           ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
           ->with(['OrderItems', 'Customer', 'User'])
           ->get(),
       ]);
   }
   
   
   

      public function preOrderToday()
      {
         $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');
         $todayStart = Carbon::now()->startOfDay();
         $todayEnd = Carbon::now()->endOfDay();
         
         return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Preorder for today",
            'data' => Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
                  $query->select('customers.id')
                     ->from('customers')
                     ->join('areas', 'customers.route_code', '=', 'areas.id')
                     ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                     ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->where('order_type', 'Pre Order')
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->with([
                  'OrderItems' => function ($query) {
                     $query->select('id', 'order_code', 'productID', 'product_name', 'quantity', 'selling_price', 'total_amount');
                  },
                  'Customer' => function ($query) {
                     $query->select('id', 'customer_name', 'email', 'phone_number', 'image', 'address', 'customer_group', 'route_code');
                  },
                  'User' => function ($query) {
                     $query->select('user_code', 'name', 'email', 'phone_number');
                  },
            ])
            ->get(),
         ]);
      }

      public function preOrderYesterday()
      {
         $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');
         $yesterdayStart = Carbon::now()->subDay()->startOfDay();
         $yesterdayEnd = Carbon::now()->subDay()->endOfDay();
         
         return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Preorder for yesterday",
            'data' => Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
                  $query->select('customers.id')
                     ->from('customers')
                     ->join('areas', 'customers.route_code', '=', 'areas.id')
                     ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                     ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->where('order_type', 'Pre Order')
            ->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
            ->with([
                  'OrderItems' => function ($query) {
                     $query->select('id', 'order_code', 'productID', 'product_name', 'quantity', 'selling_price', 'total_amount');
                  },
                  'Customer' => function ($query) {
                     $query->select('id', 'customer_name', 'email', 'phone_number', 'image', 'address', 'customer_group', 'route_code');
                  },
                  'User' => function ($query) {
                     $query->select('user_code', 'name', 'email', 'phone_number');
                  },
            ])
            ->get(),
         ]);
      }

      public function preOrderThisWeek()
      {
         $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');
         $thisWeekStart = Carbon::now()->startOfWeek();
         $thisWeekEnd = Carbon::now()->endOfWeek();
         
         return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Preorder for this week",
            'data' => Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
                  $query->select('customers.id')
                     ->from('customers')
                     ->join('areas', 'customers.route_code', '=', 'areas.id')
                     ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                     ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->where('order_type', 'Pre Order')
            ->whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])
            ->with([
                  'OrderItems' => function ($query) {
                     $query->select('id', 'order_code', 'productID', 'product_name', 'quantity', 'selling_price', 'total_amount');
                  },
                  'Customer' => function ($query) {
                     $query->select('id', 'customer_name', 'email', 'phone_number', 'image', 'address', 'customer_group', 'route_code');
                  },
                  'User' => function ($query) {
                     $query->select('user_code', 'name', 'email', 'phone_number');
                  },
            ])
            ->get(),
         ]);
      }

      public function preOrderLastWeek()
      {
         $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');
         $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
         $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
         
         return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Preorder for Last week",
            'data' => Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
                  $query->select('customers.id')
                     ->from('customers')
                     ->join('areas', 'customers.route_code', '=', 'areas.id')
                     ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                     ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->where('order_type', 'Pre Order')
            ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
            ->with([
               'OrderItems' => function ($query) {
                   $query->select('id', 'order_code', 'productID', 'product_name', 'quantity', 'selling_price', 'total_amount');
               },
               'Customer' => function ($query) {
                   $query->select('id', 'customer_name', 'email', 'phone_number', 'image', 'address', 'customer_group', 'route_code');
               },
               'User' => function ($query) {
                   $query->select('user_code', 'name', 'email', 'phone_number');
               },
           ])
           ->get(),
         ]);
      }

      public function preOrderThisMonth()
      {
         $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');
         $thisMonthStart = Carbon::now()->startOfMonth();
         $thisMonthEnd = Carbon::now()->endOfMonth();
         
         return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Preorder for this month",
            'data' => Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
                  $query->select('customers.id')
                     ->from('customers')
                     ->join('areas', 'customers.route_code', '=', 'areas.id')
                     ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                     ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->where('order_type', 'Pre Order')
            ->whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])
            ->with([
                  'OrderItems' => function ($query) {
                     $query->select('id', 'order_code', 'productID', 'product_name', 'quantity', 'selling_price', 'total_amount');
                  },
                  'Customer' => function ($query) {
                     $query->select('id', 'customer_name', 'email', 'phone_number', 'image', 'address', 'customer_group', 'route_code');
                  },
                  'User' => function ($query) {
                     $query->select('user_code', 'name', 'email', 'phone_number');
                  },
            ])
            ->get(),
         ]);
      }

      public function preOrderLastMonth()
      {
         $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');
         $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
         $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
         
         return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Preorder for last month",
            'data' => Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
                  $query->select('customers.id')
                     ->from('customers')
                     ->join('areas', 'customers.route_code', '=', 'areas.id')
                     ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                     ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->where('order_type', 'Pre Order')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->with([
               'OrderItems' => function ($query) {
                   $query->select('id', 'order_code', 'productID', 'product_name', 'quantity', 'selling_price', 'total_amount');
               },
               'Customer' => function ($query) {
                   $query->select('id', 'customer_name', 'email', 'phone_number', 'image', 'address', 'customer_group', 'route_code');
               },
               'User' => function ($query) {
                   $query->select('user_code', 'name', 'email', 'phone_number');
               },
           ])
           ->get(),
         ]);
      }

   public function orderFulfillmentToday()
   {
      return response()->json([
         'status' => 200,
         'success' => true,
         "message" => "Order fulfillment for today",
         'data' => Orders::where('order_type', 'DELIVERED')->today()->get(),
      ]);
   }
   public function orderFulfillmentWeek()
   {
      return response()->json([
         'status' => 200,
         'success' => true,
         "message" => "Order fulfillment for last week",
         'data' => Orders::where('order_type', 'DELIVERED')->lastWeek()->get(),
      ]);
   }
   public function orderFulfillmentMonth()
   {
      return response()->json([
         'status' => 200,
         'success' => true,
         "message" => "Order fulfillment for last month",
         'data' => Orders::where('order_type', 'DELIVERED')->lastMonth()->get(),
      ]);
   }
   public function visitsToday()
   {
      return response()->json([
         'status' => 200,
         'success' => true,
         "message" => "Customer Visits for today",
         "data" => checkin::with(['user', 'customer'])->select('customer_id', 'updated_at')->today()->groupBy('customer_id')->get(),
      ]);
   }
   public function visitsWeek()
   {
      return response()->json([
         'status' => 200,
         'success' => true,
         "message" => "Customer Visits for last week",
         "data" => checkin::with(['user', 'customer'])->select('customer_id', 'updated_at')->lastWeek()->groupBy('customer_id')->get(),
      ]);
   }
   public function visitsMonth()
   {
      return response()->json([
         'status' => 200,
         'success' => true,
         "message" => "Customer Visits for last month",
         "data" => checkin::with(['user', 'customer'])->select('customer_id', 'updated_at')->lastMonth()->groupBy('customer_id')->get(),
      ]);
   }
   public function activeUsersToday()
   {
      $checking = checkin::select('user_code')
         ->today()
         ->groupBy('user_code');
      $today = User::joinSub($checking, 'customer_checkin', function ($join) {
         $join->on('users.user_code', '=', 'customer_checkin.user_code');
      })->get();
      return response()->json([
         'status' => 200,
         'success' => true,
         "message" => "Active users for today",
         "data" => $today,
      ]);
   }
   public function activeUsersWeek()
   {
      $lchecking = checkin::select('user_code')
         ->lastWeek()
         ->groupBy('user_code');
      $last_week = User::joinSub($lchecking, 'customer_checkin', function ($join) {
         $join->on('users.user_code', '=', 'customer_checkin.user_code');
      })->get();
      return response()->json([
         'status' => 200,
         'success' => true,
         "message" => "Active users for last week",
         "data" => $last_week,
      ]);
   }
   public function activeUsersMonth()
   {
      $lmchecking = checkin::select('user_code')
         ->lastMonth()
         ->groupBy('user_code');
      $last_month = User::joinSub($lmchecking, 'customer_checkin', function ($join) {
         $join->on('users.user_code', '=', 'customer_checkin.user_code');
      })->get();
      return response()->json([
         'status' => 200,
         'success' => true,
         "message" => "Active users for last month",
         "data" => $last_month,
      ]);
   }
}
