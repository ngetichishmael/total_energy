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
           ->whereIn('account_type', ['Distributors', 'Lubes Sales Executive', 'Managers']);

       if ($loggedInAccountType == 'Managers') {
           $usersQuery->where('route_code', '=', $request->user()->route_code);
       }

       $users = $usersQuery->where('id', '!=', Auth::id()) // Exclude the logged-in user
           ->get();

       $message = "List of users fetched.";
       if ($loggedInAccountType == 'Managers') {
           $message .= " Filtered by manager's route code.";
       }

       return response()->json([
           "success" => true,
           "status" => 200,
           "message" => $message,
           "data" => $users,
       ]);
   }
}
