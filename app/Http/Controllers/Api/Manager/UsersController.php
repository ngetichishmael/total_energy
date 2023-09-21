<?php

namespace App\Http\Controllers\api\manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\activity_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UsersController extends Controller
{
   public function getUsers(Request $request)
   {
       $loggedInAccountType = Auth::user()->account_type;

       $usersQuery = User::withCount('Customers')
           ->with(['TargetSales', 'TargetLeads', 'TargetsOrder', 'TargetsVisit'])
           ->whereIn('account_type', ['Distributors', 'Lube Sales Executive']);

       if ($loggedInAccountType == 'Managers') {
           $usersQuery->where('route_code', '=', $request->user()->route_code);
       }

       $users = $usersQuery->where('id', '!=', Auth::id()) // Exclude the logged-in user
           ->get();

       $message = "";
       if ($loggedInAccountType == 'Managers') {
           $message .= "User List Filtered by manager's route code.";
       }

       $message .= " The list also includes sales, leads, orders, and visits targets for each user.";

       return response()->json([
           "success" => true,
           "status" => 200,
           "message" => $message,
           "data" => $users,
       ]);
   }

   public function accountTypes()
   {
       $account_types = User::whereNotIn('account_type', ['Managers', 'Admin'])
           ->select('account_type')
           ->groupBy('account_type')
           ->get()
           ->pluck('account_type')
           ->toArray();

       return response()->json([
           "success" => true,
           "status" => 200,
           "account_types" => $account_types,

       ]);
   }

   public function suspendUser(Request $request, $user_code)
   {
       $user = User::where('user_code', $user_code)->first();
   
       if (!$user) {
           return response()->json([
               "success" => false,
               "status" => 404,
               "message" => "User not found",
           ]);
       }
   
       $user->update([
           'status' => 'Disabled',
       ]);
   
       $action = "Suspended user";
       $activity = "suspended account for user " . $user->name;
       $this->activitylogs($action, $activity);
   
       return response()->json([
           "success" => true,
           "status" => 200,
           "message" => "User Disabled successfully",
           "user" => $user,
       ]);
   }

   public function activateUser(Request $request, $user_code)
    {
        $user = User::where('user_code', $user_code)->first();

        if (!$user) {
            return response()->json([
                "success" => false,
                "status" => 404,
                "message" => "User not found",
            ]);
        }

        $user->update([
            'status' => 'Active',
        ]);

        $action = "Activated user status";
        $activity = "activated status for user " . $user->name;
        $this->activitylogs($action, $activity);

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "User Activated successfully",
            "user" => $user,
        ]);
    }

    public function activitylogs($activity,$action): void
    {
       $rdm = Str::random(20);
       $activityLog = new activity_log();
       $activityLog->activity = $activity;
       $activityLog->user_code = auth()->user()->user_code;
       $activityLog->section = 'Mobile';
       $activityLog->action =  $action;
       $activityLog->userID = auth()->user()->id;
       $activityLog->activityID = $rdm;
       $activityLog->ip_address = session('login_ip');
       $activityLog->save();
    }

   

}
