<?php

namespace App\Http\Controllers\api\manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
