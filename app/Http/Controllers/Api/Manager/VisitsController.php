<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer\checkin;
use App\Models\User;
use App\Models\Subregion;
use App\Models\AssignedRegion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class VisitsController extends Controller
{
    public function getCustomerCheckins()
    {
        $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');
    
        $currentMonth = now()->startOfMonth();
        $endOfCurrentMonth = now()->endOfMonth();
    
        $customerCheckins = checkin::whereIn('customer_id', function ($query) use ($assignedRegions) {
                $query->select('customers.id')
                    ->from('customers')
                    ->join('areas', 'customers.route_code', '=', 'areas.id')
                    ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                    ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->leftJoin('customers', 'customer_checkin.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'customer_checkin.user_code', '=', 'users.user_code')
            ->whereBetween('customer_checkin.created_at', [$currentMonth, $endOfCurrentMonth])
            ->select(
                'customer_checkin.id',
                'customer_checkin.code',
                'customers.customer_name',
                'users.name as sale_associate',
                'customer_checkin.ip',
                'customer_checkin.start_time',
                'customer_checkin.stop_time',
                DB::raw('TIMEDIFF(customer_checkin.stop_time, customer_checkin.start_time) as duration'),
                'customer_checkin.created_at',
                'customer_checkin.updated_at'
            )
            ->orderByDesc('customer_checkin.created_at')
            ->get()
            ->map(function ($checkin) {
                if ($checkin->stop_time === null) {
                    $checkin->duration = "Visit Active";
                } else {
                    $start = Carbon::parse($checkin->start_time);
                    $stop = Carbon::parse($checkin->stop_time);
                    $durationInSeconds = $start->diffInSeconds($stop);
    
                    if ($durationInSeconds < 60) {
                        $checkin->duration = $durationInSeconds . ' secs';
                    } elseif ($durationInSeconds < 3600) {
                        $checkin->duration = floor($durationInSeconds / 60) . ' mins';
                    } else {
                        $checkin->duration = floor($durationInSeconds / 3600) . ' hrs';
                    }
                }
                return $checkin;
            });
    
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Customer check-ins for the current month",
            'data' => $customerCheckins,
        ]);
    }

    public function getCustomerCheckinsForCurrentDay()
    {
        $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');

        $currentDay = now()->startOfDay();
        $endOfCurrentDay = now()->endOfDay();

        $customerCheckins = checkin::whereIn('customer_id', function ($query) use ($assignedRegions) {
                $query->select('customers.id')
                    ->from('customers')
                    ->join('areas', 'customers.route_code', '=', 'areas.id')
                    ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                    ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->leftJoin('customers', 'customer_checkin.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'customer_checkin.user_code', '=', 'users.user_code')
            ->whereBetween('customer_checkin.created_at', [$currentDay, $endOfCurrentDay])
            ->select(
                'customer_checkin.id',
                'customer_checkin.code',
                'customers.customer_name',
                'users.name as sale_associate',
                'customer_checkin.ip',
                'customer_checkin.start_time',
                'customer_checkin.stop_time',
                DB::raw('TIMEDIFF(customer_checkin.stop_time, customer_checkin.start_time) as duration'),
                'customer_checkin.created_at',
                'customer_checkin.updated_at'
            )
            ->orderByDesc('customer_checkin.created_at')
            ->get()
            ->map(function ($checkin) {
                if ($checkin->stop_time === null) {
                    $checkin->duration = "Visit Active";
                } else {
                    $start = Carbon::parse($checkin->start_time);
                    $stop = Carbon::parse($checkin->stop_time);
                    $durationInSeconds = $start->diffInSeconds($stop);

                    if ($durationInSeconds < 60) {
                        $checkin->duration = $durationInSeconds . ' secs';
                    } elseif ($durationInSeconds < 3600) {
                        $checkin->duration = floor($durationInSeconds / 60) . ' mins';
                    } else {
                        $checkin->duration = floor($durationInSeconds / 3600) . ' hrs';
                    }
                }
                return $checkin;
            });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Customer check-ins for the current day",
            'data' => $customerCheckins,
        ]);
    }

    public function getCustomerCheckinsForYesterday()
    {
        $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');

        $yesterday = now()->subDay()->startOfDay();
        $endOfYesterday = now()->subDay()->endOfDay();

        $customerCheckins = checkin::whereIn('customer_id', function ($query) use ($assignedRegions) {
                $query->select('customers.id')
                    ->from('customers')
                    ->join('areas', 'customers.route_code', '=', 'areas.id')
                    ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                    ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->leftJoin('customers', 'customer_checkin.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'customer_checkin.user_code', '=', 'users.user_code')
            ->whereBetween('customer_checkin.created_at', [$yesterday, $endOfYesterday])
            ->select(
                'customer_checkin.id',
                'customer_checkin.code',
                'customers.customer_name',
                'users.name as sale_associate',
                'customer_checkin.ip',
                'customer_checkin.start_time',
                'customer_checkin.stop_time',
                DB::raw('TIMEDIFF(customer_checkin.stop_time, customer_checkin.start_time) as duration'),
                'customer_checkin.created_at',
                'customer_checkin.updated_at'
            )
            ->orderByDesc('customer_checkin.created_at')
            ->get()
            ->map(function ($checkin) {
                if ($checkin->stop_time === null) {
                    $checkin->duration = "Visit Active";
                } else {
                    $start = Carbon::parse($checkin->start_time);
                    $stop = Carbon::parse($checkin->stop_time);
                    $durationInSeconds = $start->diffInSeconds($stop);

                    if ($durationInSeconds < 60) {
                        $checkin->duration = $durationInSeconds . ' secs';
                    } elseif ($durationInSeconds < 3600) {
                        $checkin->duration = floor($durationInSeconds / 60) . ' mins';
                    } else {
                        $checkin->duration = floor($durationInSeconds / 3600) . ' hrs';
                    }
                }
                return $checkin;
            });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Customer check-ins for yesterday",
            'data' => $customerCheckins,
        ]);
    }

    public function getCustomerCheckinsForCurrentWeek()
    {
        $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $customerCheckins = checkin::whereIn('customer_id', function ($query) use ($assignedRegions) {
                $query->select('customers.id')
                    ->from('customers')
                    ->join('areas', 'customers.route_code', '=', 'areas.id')
                    ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                    ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->leftJoin('customers', 'customer_checkin.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'customer_checkin.user_code', '=', 'users.user_code')
            ->whereBetween('customer_checkin.created_at', [$startOfWeek, $endOfWeek])
            ->select(
                'customer_checkin.id',
                'customer_checkin.code',
                'customers.customer_name',
                'users.name as sale_associate',
                'customer_checkin.ip',
                'customer_checkin.start_time',
                'customer_checkin.stop_time',
                DB::raw('TIMEDIFF(customer_checkin.stop_time, customer_checkin.start_time) as duration'),
                'customer_checkin.created_at',
                'customer_checkin.updated_at'
            )
            ->orderByDesc('customer_checkin.created_at')
            ->get()
            ->map(function ($checkin) {
                if ($checkin->stop_time === null) {
                    $checkin->duration = "Visit Active";
                } else {
                    $start = Carbon::parse($checkin->start_time);
                    $stop = Carbon::parse($checkin->stop_time);
                    $durationInSeconds = $start->diffInSeconds($stop);

                    if ($durationInSeconds < 60) {
                        $checkin->duration = $durationInSeconds . ' secs';
                    } elseif ($durationInSeconds < 3600) {
                        $checkin->duration = floor($durationInSeconds / 60) . ' mins';
                    } else {
                        $checkin->duration = floor($durationInSeconds / 3600) . ' hrs';
                    }
                }
                return $checkin;
            });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Customer check-ins for the current week",
            'data' => $customerCheckins,
        ]);
    }

    public function getCustomerCheckinsForLastWeek()
    {
        $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');

        $startOfLastWeek = now()->subWeek()->startOfWeek();
        $endOfLastWeek = now()->subWeek()->endOfWeek();

        $customerCheckins = checkin::whereIn('customer_id', function ($query) use ($assignedRegions) {
                $query->select('customers.id')
                    ->from('customers')
                    ->join('areas', 'customers.route_code', '=', 'areas.id')
                    ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                    ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->leftJoin('customers', 'customer_checkin.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'customer_checkin.user_code', '=', 'users.user_code')
            ->whereBetween('customer_checkin.created_at', [$startOfLastWeek, $endOfLastWeek])
            ->select(
                'customer_checkin.id',
                'customer_checkin.code',
                'customers.customer_name',
                'users.name as sale_associate',
                'customer_checkin.ip',
                'customer_checkin.start_time',
                'customer_checkin.stop_time',
                DB::raw('TIMEDIFF(customer_checkin.stop_time, customer_checkin.start_time) as duration'),
                'customer_checkin.created_at',
                'customer_checkin.updated_at'
            )
            ->orderByDesc('customer_checkin.created_at')
            ->get()
            ->map(function ($checkin) {
                if ($checkin->stop_time === null) {
                    $checkin->duration = "Visit Active";
                } else {
                    $start = Carbon::parse($checkin->start_time);
                    $stop = Carbon::parse($checkin->stop_time);
                    $durationInSeconds = $start->diffInSeconds($stop);

                    if ($durationInSeconds < 60) {
                        $checkin->duration = $durationInSeconds . ' secs';
                    } elseif ($durationInSeconds < 3600) {
                        $checkin->duration = floor($durationInSeconds / 60) . ' mins';
                    } else {
                        $checkin->duration = floor($durationInSeconds / 3600) . ' hrs';
                    }
                }
                return $checkin;
            });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Customer check-ins for last week",
            'data' => $customerCheckins,
        ]);
    }





    public function getUserCheckins(Request $request)
    {
        $currentMonth = Carbon::now()->format('Y-m');

        $searchTerm = '%' . $request->input('search') . '%';

        // Use an alias for the query to be able to reference it in the ORDER BY clause
        $query = User::leftJoin('customer_checkin', function ($join) use ($currentMonth) {
            $join->on('users.user_code', '=', 'customer_checkin.user_code')
                ->whereRaw('customer_checkin.start_time <= customer_checkin.stop_time')
                ->whereYear('customer_checkin.created_at', '=', Carbon::parse($currentMonth)->format('Y'))
                ->whereMonth('customer_checkin.created_at', '=', Carbon::parse($currentMonth)->format('m'));
        })
            ->select(
                'users.user_code as user_code',
                'users.name as name',
                DB::raw('COUNT(customer_checkin.id) as visit_count'),
                DB::raw('MAX(customer_checkin.created_at) as last_visit_date')
            )
            ->where('users.name', 'like', $searchTerm)
            ->groupBy('users.user_code', 'users.name')
            ->havingRaw('visit_count > 0'); // Only include users with completed visits

        // Modify the SQL query to order by visit_count in descending order
        $query->orderByDesc('visit_count');

        $visits = $query->get();

        $formattedVisits = [];

        foreach ($visits as $visit) {
            $formattedVisits[] = [
                'user_code' => $visit->user_code,
                'name' => $visit->name,
                'visit_count' => $visit->visit_count,
                'last_visit_date' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('j M, Y') : 'N/A',
                'last_visit_time' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('h:i A') : 'N/A',
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'User Visits Data for the current month',
            'data' => $formattedVisits,
        ]);

        
    }

    public function getUserCheckinsToday(Request $request)
    {
        $currentDate = Carbon::now()->format('Y-m-d'); // Get the current date in Y-m-d format

        $searchTerm = '%' . $request->input('search') . '%';

        $query = User::leftJoin('customer_checkin', function ($join) use ($currentDate) {
            $join->on('users.user_code', '=', 'customer_checkin.user_code')
                ->whereRaw('customer_checkin.start_time <= customer_checkin.stop_time')
                ->whereDate('customer_checkin.created_at', '=', $currentDate); // Filter by current date
        })
            ->select(
                'users.user_code as user_code',
                'users.name as name',
                DB::raw('COUNT(customer_checkin.id) as visit_count'),
                DB::raw('MAX(customer_checkin.created_at) as last_visit_date')
            )
            ->where('users.name', 'like', $searchTerm)
            ->groupBy('users.user_code', 'users.name')
            ->havingRaw('visit_count > 0');

        $query->orderByDesc('visit_count');

        $visits = $query->get();

        $formattedVisits = [];

        foreach ($visits as $visit) {
            $formattedVisits[] = [
                'user_code' => $visit->user_code,
                'name' => $visit->name,
                'visit_count' => $visit->visit_count,
                'last_visit_date' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('j M, Y') : 'N/A',
                'last_visit_time' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('h:i A') : 'N/A',
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'User Visits Data for the current date',
            'data' => $formattedVisits,
        ]);
    }


    public function getUserCheckinsYesterday(Request $request)
    {
        $yesterday = Carbon::yesterday()->format('Y-m-d'); // Get the date for yesterday in Y-m-d format

        $searchTerm = '%' . $request->input('search') . '%';

        $query = User::leftJoin('customer_checkin', function ($join) use ($yesterday) {
            $join->on('users.user_code', '=', 'customer_checkin.user_code')
                ->whereRaw('customer_checkin.start_time <= customer_checkin.stop_time')
                ->whereDate('customer_checkin.created_at', '=', $yesterday); // Filter by yesterday's date
        })
            ->select(
                'users.user_code as user_code',
                'users.name as name',
                DB::raw('COUNT(customer_checkin.id) as visit_count'),
                DB::raw('MAX(customer_checkin.created_at) as last_visit_date')
            )
            ->where('users.name', 'like', $searchTerm)
            ->groupBy('users.user_code', 'users.name')
            ->havingRaw('visit_count > 0');

        $query->orderByDesc('visit_count');

        $visits = $query->get();

        $formattedVisits = [];

        foreach ($visits as $visit) {
            $formattedVisits[] = [
                'user_code' => $visit->user_code,
                'name' => $visit->name,
                'visit_count' => $visit->visit_count,
                'last_visit_date' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('j M, Y') : 'N/A',
                'last_visit_time' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('h:i A') : 'N/A',
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'User Visits Data for yesterday',
            'data' => $formattedVisits,
        ]);
    }

    public function getUserCheckinsCurrentWeek(Request $request)
    {
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d'); // Get the start of the current week
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');     // Get the end of the current week

        $searchTerm = '%' . $request->input('search') . '%';

        $query = User::leftJoin('customer_checkin', function ($join) use ($startOfWeek, $endOfWeek) {
            $join->on('users.user_code', '=', 'customer_checkin.user_code')
                ->whereRaw('customer_checkin.start_time <= customer_checkin.stop_time')
                ->whereDate('customer_checkin.created_at', '>=', $startOfWeek) // Filter from the start of the week
                ->whereDate('customer_checkin.created_at', '<=', $endOfWeek);   // Filter to the end of the week
        })
            ->select(
                'users.user_code as user_code',
                'users.name as name',
                DB::raw('COUNT(customer_checkin.id) as visit_count'),
                DB::raw('MAX(customer_checkin.created_at) as last_visit_date')
            )
            ->where('users.name', 'like', $searchTerm)
            ->groupBy('users.user_code', 'users.name')
            ->havingRaw('visit_count > 0');

        $query->orderByDesc('visit_count');

        $visits = $query->get();

        $formattedVisits = [];

        foreach ($visits as $visit) {
            $formattedVisits[] = [
                'user_code' => $visit->user_code,
                'name' => $visit->name,
                'visit_count' => $visit->visit_count,
                'last_visit_date' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('j M, Y') : 'N/A',
                'last_visit_time' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('h:i A') : 'N/A',
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'User Visits Data for the current week',
            'data' => $formattedVisits,
        ]);
    }

    public function getUserCheckinsLastWeek(Request $request)
    {
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'); // Get the start of last week
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d');     // Get the end of last week

        $searchTerm = '%' . $request->input('search') . '%';

        $query = User::leftJoin('customer_checkin', function ($join) use ($startOfLastWeek, $endOfLastWeek) {
            $join->on('users.user_code', '=', 'customer_checkin.user_code')
                ->whereRaw('customer_checkin.start_time <= customer_checkin.stop_time')
                ->whereDate('customer_checkin.created_at', '>=', $startOfLastWeek) // Filter from the start of last week
                ->whereDate('customer_checkin.created_at', '<=', $endOfLastWeek);   // Filter to the end of last week
        })
            ->select(
                'users.user_code as user_code',
                'users.name as name',
                DB::raw('COUNT(customer_checkin.id) as visit_count'),
                DB::raw('MAX(customer_checkin.created_at) as last_visit_date')
            )
            ->where('users.name', 'like', $searchTerm)
            ->groupBy('users.user_code', 'users.name')
            ->havingRaw('visit_count > 0');

        $query->orderByDesc('visit_count');

        $visits = $query->get();

        $formattedVisits = [];

        foreach ($visits as $visit) {
            $formattedVisits[] = [
                'user_code' => $visit->user_code,
                'name' => $visit->name,
                'visit_count' => $visit->visit_count,
                'last_visit_date' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('j M, Y') : 'N/A',
                'last_visit_time' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('h:i A') : 'N/A',
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'User Visits Data for last week',
            'data' => $formattedVisits,
        ]);
    }

    public function getUserCheckinsCurrentMonth(Request $request)
    {
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d'); // Get the start of the current month
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');     // Get the end of the current month

        $searchTerm = '%' . $request->input('search') . '%';

        $query = User::leftJoin('customer_checkin', function ($join) use ($startOfMonth, $endOfMonth) {
            $join->on('users.user_code', '=', 'customer_checkin.user_code')
                ->whereRaw('customer_checkin.start_time <= customer_checkin.stop_time')
                ->whereDate('customer_checkin.created_at', '>=', $startOfMonth) // Filter from the start of the current month
                ->whereDate('customer_checkin.created_at', '<=', $endOfMonth);   // Filter to the end of the current month
        })
            ->select(
                'users.user_code as user_code',
                'users.name as name',
                DB::raw('COUNT(customer_checkin.id) as visit_count'),
                DB::raw('MAX(customer_checkin.created_at) as last_visit_date')
            )
            ->where('users.name', 'like', $searchTerm)
            ->groupBy('users.user_code', 'users.name')
            ->havingRaw('visit_count > 0');

        $query->orderByDesc('visit_count');

        $visits = $query->get();

        $formattedVisits = [];

        foreach ($visits as $visit) {
            $formattedVisits[] = [
                'user_code' => $visit->user_code,
                'name' => $visit->name,
                'visit_count' => $visit->visit_count,
                'last_visit_date' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('j M, Y') : 'N/A',
                'last_visit_time' => $visit->last_visit_date ? Carbon::parse($visit->last_visit_date)->format('h:i A') : 'N/A',
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'User Visits Data for the current month',
            'data' => $formattedVisits,
        ]);
    }




    public function getCustomerCheckinsForCurrentMonth()
    {
        $assignedRegions = AssignedRegion::where('user_code', auth()->user()->user_code)->pluck('region_id');

        $startOfCurrentMonth = now()->startOfMonth();
        $endOfCurrentMonth = now()->endOfMonth();

        $customerCheckins = checkin::whereIn('customer_id', function ($query) use ($assignedRegions) {
                $query->select('customers.id')
                    ->from('customers')
                    ->join('areas', 'customers.route_code', '=', 'areas.id')
                    ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                    ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->leftJoin('customers', 'customer_checkin.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'customer_checkin.user_code', '=', 'users.user_code')
            ->whereBetween('customer_checkin.created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
            ->select(
                'customer_checkin.id',
                'customer_checkin.code',
                'customers.customer_name',
                'users.name as sale_associate',
                'customer_checkin.ip',
                'customer_checkin.start_time',
                'customer_checkin.stop_time',
                DB::raw('TIMEDIFF(customer_checkin.stop_time, customer_checkin.start_time) as duration'),
                'customer_checkin.created_at',
                'customer_checkin.updated_at'
            )
            ->orderByDesc('customer_checkin.created_at')
            ->get()
            ->map(function ($checkin) {
                if ($checkin->stop_time === null) {
                    $checkin->duration = "Visit Active";
                } else {
                    $start = Carbon::parse($checkin->start_time);
                    $stop = Carbon::parse($checkin->stop_time);
                    $durationInSeconds = $start->diffInSeconds($stop);

                    if ($durationInSeconds < 60) {
                        $checkin->duration = $durationInSeconds . ' secs';
                    } elseif ($durationInSeconds < 3600) {
                        $checkin->duration = floor($durationInSeconds / 60) . ' mins';
                    } else {
                        $checkin->duration = floor($durationInSeconds / 3600) . ' hrs';
                    }
                }
                return $checkin;
            });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Customer check-ins for the current month",
            'data' => $customerCheckins,
        ]);
    }


    public function viewUserCheckins(Request $request, $user_code)
    {
        // Get the username associated with the user code
        $username = User::where('user_code', $user_code)->value('name');

        // Perform the database query to retrieve completed user visits data
        $visits = DB::table('users')
            ->join('customer_checkin', 'users.user_code', '=', 'customer_checkin.user_code')
            ->join('customers', 'customer_checkin.customer_id', '=', 'customers.id')
            ->where('users.user_code', $user_code)
            ->whereNotNull('customer_checkin.start_time')
            ->whereNotNull('customer_checkin.stop_time')
            ->select(
                'customer_checkin.id as id',
                'customer_checkin.code as code',
                'customers.customer_name AS customer_name',
                DB::raw("DATE_FORMAT(customer_checkin.start_time, '%h:%i %p') AS start_time"),
                DB::raw("DATE_FORMAT(customer_checkin.stop_time, '%h:%i %p') AS stop_time"),
                DB::raw("TIME_TO_SEC(TIMEDIFF(customer_checkin.stop_time, customer_checkin.start_time)) AS duration_seconds"),
                DB::raw("DATE_FORMAT(customer_checkin.updated_at, '%d/%m/%Y') as formatted_date")
            )
            ->orderBy('customer_checkin.updated_at', 'DESC')
            ->get(); // Remove pagination

        // Format the response data, including the duration
        $formattedVisits = $visits->map(function ($visit, $key) {
            $duration = $this->formatDuration($visit->duration_seconds);
            return [
                'id' => $visit->id,
                'code' => $visit->code,
                'customer_name' => $visit->customer_name,
                'start_time' => $visit->start_time,
                'stop_time' => $visit->stop_time,
                'duration' => $duration,
                'formatted_date' => $visit->formatted_date,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Completed User Visits Data',
            'data' => $formattedVisits
        ]);
    }

    /**
     * Format the duration into a human-readable format.
     *
     * @param int $durationSeconds The duration in seconds.
     * @return string The formatted duration.
     */
    private function formatDuration($durationSeconds)
    {
        if ($durationSeconds < 60) {
            return "{$durationSeconds} secs";
        } elseif ($durationSeconds < 3600) {
            $minutes = floor($durationSeconds / 60);
            return "{$minutes} mins";
        } else {
            $hours = floor($durationSeconds / 3600);
            return "{$hours} hrs";
        }
    }


}
