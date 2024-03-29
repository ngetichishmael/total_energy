<?php

namespace App\Http\Controllers\app;

use App\Helpers\SMS;
use App\Http\Controllers\Controller;
use App\Models\AppPermission;
use App\Models\AssignedRegion;
use App\Models\Region;
use App\Models\suppliers\suppliers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class usersController extends Controller
{

    public function getUsers(Request $request)
    {
        $accountType = $request->input('account_type');
        $users = User::where('account_type', $accountType)->get();

        return response()->json(['users' => $users]);
    }
    public function getDistributors(Request $request)
    {
        $distributors = suppliers::orWhereNull('name')
            ->orWhereNull('status')
            ->get();

        return response()->json(['users' => $distributors]);
    }

    //list
    public function list()
    {
        return view('app.users.usertypes');
    }
    public function index()
    {
        return view('app.users.usertypes');
    }

    public function admins()
    {
        $admins = User::where('account_type', 'Admin');
        return view('app.users.admins', compact('admins'));
    }

    public function lubemerchandizer()
    {
        $Merchandizer = User::where('account_type', 'Lube Merchandizers');
        return view('app.users.Merchandizer', compact('Merchandizer'));
    }

    public function LubeSalesExecutive()
    {
        $LubeSalesExecutive = User::where('account_type', 'Lube Sales Executive');
        return view('app.users.LubeSalesExecutive', compact('LubeSalesExecutive'));
    }

    public function sales()
    {
        $sales = User::where('account_type', 'Sales');
        return view('app.users.sales', compact('sales'));
    }

    public function Distributors()
    {
        $Distributors = User::where('account_type', 'Distributors');
        return view('app.users.distributors', compact('Distributors'));
    }

    public function Managers()
    {
        $Distributors = User::where('account_type', 'Managers');
        return view('app.users.managers', compact('Distributors'));
    }

    public function indexUser()
    {
        return view('app.users.import');
    }

    //create
    public function create()
    {
        // $routes = array_merge($regions, $subregions, $zones);
        $routes = Region::all();
        return view('app.users.create', [
            "routes" => $routes,
        ]);
    }

    //store
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users,email',
            'name' => 'required',
            'phone_number' => 'required',
            'account_type' => 'required',
            'route' => 'required',
        ]);

        $user_code = Str::uuid();
        $password = $request->password === null ? 'password' : $request->password;
        // Save user
        foreach ($request->route as $route) {
            $routes = new AssignedRegion();
            $routes->region_id = $route;
            $routes->user_code = $user_code;
            $routes->save();
        }
        $assigned_route = AssignedRegion::where('user_code', $user_code)->first();
        User::updateOrCreate(
            ["user_code" => $user_code],
            [
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "name" => $request->name,
                "account_type" => $request->account_type,
                "email_verified_at" => now(),
                "route_code" => $assigned_route->region_id,
                "status" => 'Active',
                "password" => Hash::make($password),
                "business_code" => FacadesAuth::user()->business_code,
            ]
        );

        // Update or create app permissions
        $van_sales = $request->van_sales == null ? "NO" : "YES";
        $new_sales = $request->new_sales == null ? "NO" : "YES";
        $deliveries = $request->deliveries == null ? "NO" : "YES";
        $schedule_visits = $request->schedule_visits == null ? "NO" : "YES";
        $merchandizing = $request->merchandizing == null ? "NO" : "YES";

        AppPermission::updateOrCreate(
            ["user_code" => $user_code],
            [
                "van_sales" => $van_sales,
                "new_sales" => $new_sales,
                "schedule_visits" => $schedule_visits,
                "deliveries" => $deliveries,
                "merchandizing" => $merchandizing,
            ]
        );
        $message = "Your login information is username " . $request->phone_number . ' and password is ' . $password;
        if (in_array($request->account, ['Admin', 'Manager'])) {
            $message = "Your login information is username " . $request->email . ' and password ' . $password;
        }
        (new SMS())($request->phone_number, $message);
        session()->flash('success', 'User Created Successfully');
        return redirect()->route('users.list');
    }

    public function edit($id)
    {
        $permissions = array();
        $edit = User::whereId($id)->first();
        $permissions = AppPermission::where('user_code', $edit->user_code)->first();
        if ($permissions == null) {
            $permissions = AppPermission::Create(
                [
                    "user_code" => $edit->user_code,
                    "van_sales" => "NO",
                    "new_sales" => "NO",
                    "schedule_visits" => "NO",
                    "deliveries" => "NO",
                    "merchanizing" => "NO",
                ]
            );
        }
        $routes = Region::all();
        return view('app.users.edit', [
            'edit' => $edit,
            'user_code' => $edit->user_code,
            'permissions' => $permissions,
            "routes" => $routes,
        ]);
    }

    public function view($user_code)
    {
        $edit = User::where('user_code', $user_code)
            ->where('business_code', FacadesAuth::user()->business_code)
            ->first();

        $permissions = AppPermission::where('user_code', $user_code)->first();
        if ($permissions == null) {
            $permissions = AppPermission::updateOrCreate(
                [
                    "user_code" => $edit->user_code,

                ],
                [
                    "van_sales" => "NO",
                    "new_sales" => "NO",
                    "schedule_visits" => "NO",
                    "deliveries" => "NO",
                    "merchanizing" => "NO",
                ]
            );
        }
        $regions = Region::all();

        return view('app.users.view', [
            'edit' => $edit,
            'user_code' => $user_code,
            'permissions' => $permissions,
            'regions' => $regions,
        ]);
    }

    //update
    public function update(Request $request, $user_code)
    {
        AssignedRegion::where('user_code', $user_code)->delete();
        foreach ($request->route as $route) {
            AssignedRegion::create([
                "user_code" => $user_code,
                "region_id" => $route,
            ]
            );
        }
        $assigned_route = AssignedRegion::where('user_code', $user_code)->first();

        $user = User::where('user_code', '=', $user_code)->first();
        User::updateOrCreate(
            [
                "user_code" => $user_code,
            ],
            [
                "email" => $request->email ?? $user->email,
                "phone_number" => $request->phone_number ?? $user->phone_number,
                "route_code" => $assigned_route->region_id,
                "name" => $request->name ?? $user->name,
                "account_type" => $request->account_type ?? $user->account_type,
                "status" => 'Active',
                "password" => $request->password === null ? $user->password : Hash::make($request->password),

            ]
        );

        $van_sales = $request->van_sales == null ? "NO" : "YES";
        $new_sales = $request->new_sales == null ? "NO" : "YES";
        $deliveries = $request->deliveries == null ? "NO" : "YES";
        $schedule_visits = $request->schedule_visits == null ? "NO" : "YES";
        $merchanizing = $request->merchanizing == null ? "NO" : "YES";
        AppPermission::updateOrCreate(
            [
                "user_code" => $user_code,
            ],
            [
                "van_sales" => $van_sales,
                "new_sales" => $new_sales,
                "schedule_visits" => $schedule_visits,
                "deliveries" => $deliveries,
                "merchanizing" => $merchanizing,
            ]
        );
        if ($request->password) {
            $message = "Your data has been updated login with " . $request->phone_number . ' and new password is ' . $request->password;
            if (in_array($request->account, ['Admin', 'Manager'])) {
                $message = "Your  data has been updated login with " . $request->email . ' and new password is ' . $request->password;
            }
            (new SMS())($request->phone_number, $message);
        }
        Session()->flash('success', 'User updated Successfully');
        return redirect()->route('users.list');
    }
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        Session()->flash('success', 'User deleted Successfully');
        return redirect()->route('users.list');
    }
    public function import()
    {
        abort(403, "This action is Limited to Admin Only");
    }
}
