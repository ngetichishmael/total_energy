<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer\customers;
use App\Models\Routes;
use App\Models\Route_customer;
use App\Models\Route_sales;
use App\Models\User;
use Auth;
use Helper;
use Session;
use DB;

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
      //
   //   $show = Route_sales::join('routes','routes.route_code','=','route_sales.routeID')->where('userID', $id);
     
     $show_routes = DB::table('route_sales')
     ->where('route_sales.userID', $id)
     ->join('routes', 'routes.route_code', '=', 'route_sales.routeID')
     ->join('route_customer', 'route_customer.routeID', '=', 'route_sales.routeID' )
     ->join('customers', 'customers.id', '=', 'route_customer.customerID')
     ->select('routes.name','routes.route_code','routes.status','routes.start_date','routes.end_date','customers.customer_name')
     
     ->get();
     return response()->json([
         "success" => true,
         "message" => "Routes fetched successfully",
         "user routes" => $show_routes,
      ]);
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      //
   }
}
