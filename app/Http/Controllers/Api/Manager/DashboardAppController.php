<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Models\customer\checkin;
use App\Models\customer\customers;
use App\Models\inventory\allocations;
use App\Models\Orders;
use App\Models\survey\survey;
use App\Models\User;
use App\Models\Region;
use App\Models\Routes;
use App\Models\Subregion;
use App\Models\AssignedRegion;
use App\Models\Area;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAppController extends Controller
{
   public function dashboard(Request $request)
   {
        $currentUserRouteCode = auth()->user()->route_code;

        // $all = User::where('route_code', $currentUserRouteCode)
        //     ->where('id', '<>', auth()->user()->id) 
        //     ->count();
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
        
       


       


        if ($user->account_type === 'Admin') {

            $today = User::joinSub(
                checkin::select('user_code')
                    ->whereBetween('created_at', [$todayStart, $todayEnd])
                    ->groupBy('user_code'),
                'customer_checkin',
                function ($join) {
                    $join->on('users.user_code', '=', 'customer_checkin.user_code');
                }
            )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
            ->distinct('users.id')->count();
            
            $yesterday = User::joinSub(
                checkin::select('user_code')
                    ->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
                    ->groupBy('user_code'),
                'customer_checkin',
                function ($join) {
                    $join->on('users.user_code', '=', 'customer_checkin.user_code');
                }
            )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
            ->distinct('users.id')->count();
            
            $this_week = User::joinSub(
                checkin::select('user_code')
                    ->whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])
                    ->groupBy('user_code'),
                'customer_checkin',
                function ($join) {
                    $join->on('users.user_code', '=', 'customer_checkin.user_code');
                }
            )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
            ->distinct('users.id')->count();
            
            $last_week = User::joinSub(
                checkin::select('user_code')
                    ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                    ->groupBy('user_code'),
                'customer_checkin',
                function ($join) {
                    $join->on('users.user_code', '=', 'customer_checkin.user_code');
                }
            )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
            ->distinct('users.id')->count();
            
            $current_month_users = User::joinSub(
                checkin::select('user_code')
                    ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                    ->groupBy('user_code'),
                'customer_checkin',
                function ($join) {
                    $join->on('users.user_code', '=', 'customer_checkin.user_code');
                }
            )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
            ->distinct('users.id')->count();
            
            $last_month_users = User::joinSub(
                checkin::select('user_code')
                    ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                    ->groupBy('user_code'),
                'customer_checkin',
                function ($join) {
                    $join->on('users.user_code', '=', 'customer_checkin.user_code');
                }
            )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
            ->distinct('users.id')->count();

            // Calculate the visit statistics for different time intervals
        $todayVisits = Checkin::whereBetween('updated_at', [Carbon::today(), Carbon::tomorrow()])
            ->distinct('code')->count();

        $yesterdayVisits = Checkin::whereBetween('updated_at', [Carbon::yesterday(), Carbon::today()])
            ->distinct('code')->count();
     
        $thisWeekVisits = Checkin::whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->distinct('code')->count();
        
        $lastWeekVisits = Checkin::whereBetween('updated_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])
            ->distinct('code')->count();
        
        $thisMonthVisits = Checkin::whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->distinct('code')->count();
        
        $lastMonthVisits = Checkin::whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->endOfMonth()->subMonth()])
            ->distinct('code')->count();

        } else {

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
            
            $this_week = User::where('route_code', auth()->user()->route_code)->joinSub(
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
            
            $current_month_users = User::where('route_code', auth()->user()->route_code)->joinSub(
                checkin::select('user_code')
                    ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                    ->groupBy('user_code'),
                'customer_checkin',
                function ($join) {
                    $join->on('users.user_code', '=', 'customer_checkin.user_code');
                }
            )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
            ->distinct('users.id')->count();
            
            $last_month_users = User::where('route_code', auth()->user()->route_code)->joinSub(
                checkin::select('user_code')
                    ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                    ->groupBy('user_code'),
                'customer_checkin',
                function ($join) {
                    $join->on('users.user_code', '=', 'customer_checkin.user_code');
                }
            )->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
            ->distinct('users.id')->count();

            
         // Calculate the visit statistics for different time intervals
        $todayVisits = Checkin::whereIn('customer_id', $assignedCustomerIds)
            ->whereBetween('updated_at', [Carbon::today(), Carbon::tomorrow()])
            ->distinct('code')->count();

        $yesterdayVisits = Checkin::whereIn('customer_id', $assignedCustomerIds)
            ->whereBetween('updated_at', [Carbon::yesterday(), Carbon::today()])
            ->distinct('code')->count();
     
        $thisWeekVisits = Checkin::whereIn('customer_id', $assignedCustomerIds)
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->distinct('code')->count();
        
        $lastWeekVisits = Checkin::whereIn('customer_id', $assignedCustomerIds)
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])
            ->distinct('code')->count();
        
        $thisMonthVisits = Checkin::whereIn('customer_id', $assignedCustomerIds)
            ->whereBetween('updated_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->distinct('code')->count();
        
        $lastMonthVisits = Checkin::whereIn('customer_id', $assignedCustomerIds)
            ->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->endOfMonth()->subMonth()])
            ->distinct('code')->count();

         // Calculate the order counts for different time intervals
         $todayOrders = Orders::whereIn('customerID', $assignedCustomerIds)
         ->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])
         ->count();
 
         $yesterdayOrders = Orders::whereIn('customerID', $assignedCustomerIds)
             ->whereBetween('created_at', [Carbon::yesterday(), Carbon::today()])
             ->count();
 
         $thisWeekOrders = Orders::whereIn('customerID', $assignedCustomerIds)
             ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
             ->count();
 
         $lastWeekOrders = Orders::whereIn('customerID', $assignedCustomerIds)
             ->whereBetween('created_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])
             ->count();
 
         $thisMonthOrders = Orders::whereIn('customerID', $assignedCustomerIds)
             ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
             ->count();
        }

       $data = [
         'status' => 200,
         'success' => true,
         'message' => "Dashboard summary data for the Managers's assigned regions",
         'active_users' => [
            'today' => $today,
            'yesterday' => $yesterday,
            'this_week' => $this_week,
            'last_week' => $last_week,
            'this_month' => $current_month_users,
            'last_month' => $last_month_users,
            'user_count' => $all,
         ],
         'new_customers_visits' => [
            'today' => $todayVisits,
            'yesterday' => $yesterdayVisits,
            'this_week' => $thisWeekVisits,
            'last_week' => $lastWeekVisits,
            'this_month' => $thisMonthVisits,
            'last_month' => $lastMonthVisits,
         ],
        //  'order_counts' => [
        //     'today' => $todayOrders,
        //     'yesterday' => $yesterdayOrders,
        //     'this_week' => $thisWeekOrders,
        //     'last_week' => $lastWeekOrders,
        //     'this_month' => $thisMonthOrders,
        //  ],
        'new_customers_added' => [
            'today' => $user->account_type === 'Admin' ?
                customers::whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])
                ->count() :
                customers::whereIn('route_code', function ($query) use ($assignedRegions, $user) {
                    $query->select('areas.id')
                        ->from('areas')
                        ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                        ->whereIn('subregions.region_id', $assignedRegions);
                })
                ->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])
                ->count(),
        
            'yesterday' => $user->account_type === 'Admin' ?
                customers::whereBetween('created_at', [Carbon::yesterday(), Carbon::today()])
                ->count() :
                customers::whereIn('route_code', function ($query) use ($assignedRegions, $user) {
                    $query->select('areas.id')
                        ->from('areas')
                        ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                        ->whereIn('subregions.region_id', $assignedRegions);
                })
                ->whereBetween('created_at', [Carbon::yesterday(), Carbon::today()])
                ->count(),
        
            'this_week' => $user->account_type === 'Admin' ?
                customers::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count() :
                customers::whereIn('route_code', function ($query) use ($assignedRegions, $user) {
                    $query->select('areas.id')
                        ->from('areas')
                        ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                        ->whereIn('subregions.region_id', $assignedRegions);
                })
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count(),
        
            'last_week' => $user->account_type === 'Admin' ?
                customers::whereBetween('created_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])
                ->count() :
                customers::whereIn('route_code', function ($query) use ($assignedRegions, $user) {
                    $query->select('areas.id')
                        ->from('areas')
                        ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                        ->whereIn('subregions.region_id', $assignedRegions);
                })
                ->whereBetween('created_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])
                ->count(),
        
            'this_month' => $user->account_type === 'Admin' ?
                customers::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                ->count() :
                customers::whereIn('route_code', function ($query) use ($assignedRegions, $user) {
                    $query->select('areas.id')
                        ->from('areas')
                        ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                        ->whereIn('subregions.region_id', $assignedRegions);
                })
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                ->count(),
        
            'last_month' => $user->account_type === 'Admin' ?
                customers::whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->endOfMonth()->subMonth()])
                ->count() :
                customers::whereIn('route_code', function ($query) use ($assignedRegions, $user) {
                    $query->select('areas.id')
                        ->from('areas')
                        ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                        ->whereIn('subregions.region_id', $assignedRegions);
                })
                ->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->endOfMonth()->subMonth()])
                ->count(),
        ],
        

        'pre_sales_value' => [
            'today' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])
                    ->count(),
        
            'yesterday' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::yesterday(), Carbon::today()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::yesterday(), Carbon::today()])
                    ->count(),
        
            'this_week' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->count(),
        
            'last_week' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])
                    ->count(),
        
            'this_month' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->count(),
        
            'last_month' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->endOfMonth()->subMonth()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Pre Order')
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->endOfMonth()->subMonth()])
                    ->count(),
        ],
        

        'Van_sales_value' => [
            'today' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])
                    ->count(),
        
            'yesterday' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::yesterday(), Carbon::today()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::yesterday(), Carbon::today()])
                    ->count(),
        
            'this_week' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->count(),
        
            'last_week' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])
                    ->count(),
        
            'this_month' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->count(),
        
            'last_month' => $user->account_type === 'Admin' ?
                Orders::where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->endOfMonth()->subMonth()])
                    ->count() :
                Orders::whereIn('customerID', $assignedCustomerIds)
                    ->where('order_type', 'Van sales')
                    ->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->endOfMonth()->subMonth()])
                    ->count(),
        ],
        

        'pending_approval' => $user->account_type === 'Admin' ?
            Orders::where('order_status', 'Pending Delivery')
            ->where('order_type', 'Pre Order')
            ->count() :
            Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
                $query->select('customers.id')
                    ->from('customers')
                    ->join('areas', 'customers.route_code', '=', 'areas.id')
                    ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                    ->whereIn('subregions.region_id', $assignedRegions);
            })
        ->where('order_status', 'Pending Delivery')
        ->where('order_type', 'Pre Order')
        ->count(),
     
     

        'completed_deliveries' => $user->account_type === 'Admin' ?
            Orders::where('order_status', 'DELIVERED')
            ->where('order_type', 'Pre Order')
            ->count() :
            Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
                $query->select('customers.id')
                    ->from('customers')
                    ->join('areas', 'customers.route_code', '=', 'areas.id')
                    ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                    ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->where('order_status', 'DELIVERED')
            ->where('order_type', 'Pre Order')
            ->count(),

      ];
      return response()->json($data, 200);
   }

//    public function custom(Request $request)
//    {
//       $start_date = $request->start_date;
//       $end_date = $request->end_date;
//       $checking = checkin::select('user_code')->period($start_date, $end_date)->groupBy('user_code');
//       $today = User::joinSub($checking, 'customer_checkin', function ($join) {
//          $join->on('users.user_code', '=', 'customer_checkin.user_code');
//       })->count();
//       $data = [
// //         'status' => 200,
// //         'success' => true,
//          'active_users' => $today,
//          'new_customers_visits' => checkin::select('customer_id', 'updated_at')->period($start_date, $end_date)->groupBy('customer_id')->count(),
//          'new_customers_added' =>  customers::period($start_date, $end_date)->count(),
//          'pre_sales_value' => Orders::where('order_type', 'Pre Order')->period($start_date, $end_date)->count(),
//          'existing_customer_visit' => customers::period($start_date, $end_date)->count(),
//          'pending_approval' => allocations::where('status', 'Waiting acceptance')->period($start_date, $end_date)->count(),
//          'completed_forms' => survey::where('status', 'Completed')->period($start_date, $end_date)->count(),
//       ];
//       return response()->json($data, 200);

//    }

public function custom(Request $request)
{
    $loggedInUserId = auth()->user()->id; // Get the logged-in user's ID

    $start_date = $request->start_date;
    $end_date = $request->end_date;
    
    $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');
    
    $checking = Checkin::whereIn('customer_id', function ($query) use ($assignedRegions) {
        $query->select('customers.id')
            ->from('customers')
            ->join('areas', 'customers.route_code', '=', 'areas.id')
            ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
            ->whereIn('subregions.region_id', $assignedRegions);
    })
    ->period($start_date, $end_date)
    ->groupBy('user_code');

    // $activeUsers = User::joinSub($checking, 'customer_checkin', function ($join) {
    //     $join->on('users.user_code', '=', 'customer_checkin.user_code');
    // })->count();

    $activeUsers = User::where('route_code', auth()->user()->route_code)
    ->joinSub(
        Checkin::select('user_code')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('user_code'),
        'customer_checkin',
        function ($join) {
            $join->on('users.user_code', '=', 'customer_checkin.user_code');
        }
    )
    ->where('users.id', '<>', $loggedInUserId) // Exclude logged-in user
    ->distinct('users.id')
    ->count();



    $newCustomersVisits = Checkin::whereIn('customer_id', function ($query) use ($assignedRegions) {
        $query->select('customers.id')
            ->from('customers')
            ->join('areas', 'customers.route_code', '=', 'areas.id')
            ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
            ->whereIn('subregions.region_id', $assignedRegions);
    })
    ->period($start_date, $end_date)
    ->distinct('code')
    ->count();

    $newCustomersAdded = customers::whereIn('route_code', function ($query) use ($assignedRegions) {
        $query->select('areas.id')
            ->from('areas')
            ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
            ->whereIn('subregions.region_id', $assignedRegions);
    })
    ->whereBetween('created_at', [$start_date, $end_date])
    ->count();

    $preSalesValue = Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
        $query->select('customers.id')
            ->from('customers')
            ->join('areas', 'customers.route_code', '=', 'areas.id')
            ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
            ->whereIn('subregions.region_id', $assignedRegions);
    })
    ->where('order_type', 'Pre Order')
    ->whereBetween('created_at', [$start_date, $end_date])
    ->count();

    $vanSalesValue = Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
        $query->select('customers.id')
            ->from('customers')
            ->join('areas', 'customers.route_code', '=', 'areas.id')
            ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
            ->whereIn('subregions.region_id', $assignedRegions);
    })
    ->where('order_type', 'Van sales')
    ->whereBetween('created_at', [$start_date, $end_date])
    ->count();

    $pendingApproval = allocations::where('status', 'Waiting acceptance')
    ->whereHas('user', function ($query) use ($start_date, $end_date) {
        $query->where('route_code', auth()->user()->route_code)
            ->where('id', '!=', auth()->user()->id) // Exclude the logged-in user's ID
            ->whereBetween('created_at', [$start_date, $end_date]); // Apply date filter
    })
    ->count();

    $completedDeliveries = Orders::whereIn('customerID', function ($query) use ($assignedRegions) {
        $query->select('customers.id')
            ->from('customers')
            ->join('areas', 'customers.route_code', '=', 'areas.id')
            ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
            ->whereIn('subregions.region_id', $assignedRegions);
    })
    ->where('order_status', 'DELIVERED')
    ->where('order_type', 'Pre Order')
    ->whereBetween('created_at', [$start_date, $end_date])
    ->count();

    $data = [
        'status' => 200,
        'success' => true,
        'message' => 'Filtered data based on the date range',
        'data' => [
            'active_users' => $activeUsers,
            'new_customers_visits' => $newCustomersVisits,
            'new_customers_added' => $newCustomersAdded,
            'pre_sales_value' => $preSalesValue,
            'van_sales_value' => $vanSalesValue,
            'pending_approval' => $pendingApproval,
            'completed_deliveries' => $completedDeliveries,
            // Add more data points as needed
        ]
    ];

    return response()->json($data, 200);
}

}