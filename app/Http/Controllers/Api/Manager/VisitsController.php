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

        $customerCheckins = checkin::whereIn('customer_id', function ($query) use ($assignedRegions) {
                $query->select('customers.id')
                    ->from('customers')
                    ->join('areas', 'customers.route_code', '=', 'areas.id')
                    ->join('subregions', 'areas.subregion_id', '=', 'subregions.id')
                    ->whereIn('subregions.region_id', $assignedRegions);
            })
            ->leftJoin('customers', 'customer_checkin.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'customer_checkin.user_code', '=', 'users.user_code')
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
            'message' => "Customer check-ins",
            'data' => $customerCheckins,
        ]);
    }
}
