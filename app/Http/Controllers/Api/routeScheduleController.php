<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB as FacadesDB;

class routeScheduleController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show_routes = FacadesDB::table('route_sales')
            ->where('route_sales.userID', '=', $id)
            ->leftJoin('routes', 'routes.route_code', '=', 'route_sales.routeID')
            ->leftJoin('route_customer', 'route_customer.routeID', '=', 'route_sales.routeID')
            ->leftJoin('customers', 'customers.id', '=', 'route_customer.customerID')
            ->select(
                'routes.name',
                'routes.route_code',
                'routes.status',
                'routes.Type',
                'routes.start_date',
                'routes.end_date',
                'customers.id',
                'customers.account',
                'customers.customer_name',
                'customers.address',
                'customers.email',
                'customers.phone_number',
                'customers.latitude',
                'customers.longitude'
            )
            ->whereNotNull('routes.name')
            ->get();

        return response()->json([
            "success" => true,
            "message" => "Routes fetched successfully",
            "user routes" => $show_routes,
        ]);
    }
}
