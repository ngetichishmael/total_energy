<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\customer\customers;
use App\Models\Relationship;
use App\Models\Routes;
use App\Models\Route_customer;
use App\Models\Route_sales;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class routesController extends Controller
{

    public function index(): Response | View
    {
        return view('app.routes.index');
    }
    public function individual()
    {
        return view('app.routes.individual');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response | View
    {
        $customers = customers::pluck('customer_name', 'id');
        $salesPeople = User::pluck('name', 'id');
        $zones = Relationship::where('has_children', '0')->pluck('name', 'name');

        return view('app.routes.create', compact('customers', 'salesPeople', 'zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            'end_date' => 'required',
        ]);

        $code = Str::random(20);
        $route = new Routes;
        $route->business_code = Auth::user()->business_code;
        $route->route_code = $code;
        $route->name = $request->name;
        $route->status = $request->status;
        $route->Type = "Assigned";
        $route->start_date = $request->start_date;
        $route->end_date = $request->end_date;
        $route->created_by = Auth::user()->user_code;
        $route->save();

        //save customers
        $customersCount = count(collect($request->customers));
        if ($customersCount > 0) {
            for ($i = 0; $i < count($request->customers); $i++) {
                $customers = new Route_customer;
                $customers->business_code = Auth::user()->business_code;
                $customers->routeID = $code;
                $customers->customerID = $request->customers[$i];
                $customers->created_by = Auth::user()->user_code;
                $customers->save();
            }
        }

        //save sales person
        $salescount = count(collect($request->sales_persons));
        if ($salescount > 0) {
            for ($i = 0; $i < count($request->sales_persons); $i++) {
                $sales = new Route_sales;
                $sales->business_code = Auth::user()->business_code;
                $sales->routeID = $code;
                $sales->userID = $request->sales_persons[$i];
                $sales->created_by = Auth::user()->user_code;
                $sales->save();
            }
        }

        Session()->flash('success', 'Route successfully added');

        return redirect()->route('routes.index');
    }

}
