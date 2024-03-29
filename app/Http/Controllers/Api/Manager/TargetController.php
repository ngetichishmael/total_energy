<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Models\activity_log;
use App\Models\LeadsTargets;
use App\Models\OrdersTarget;
use App\Models\SalesTarget;
use App\Models\User;
use App\Models\VisitsTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TargetController extends Controller
{
   protected $lastDayofMonth;

   public function __construct()
   {
      $this->lastDayofMonth =  Carbon::parse(Carbon::now())->endOfMonth()->toDateString();;
   }

   public function assignVisitTarget(Request $request)
   {
       $validator = Validator::make($request->all(), [
           "user_code" => "required",
           "target"    => "required",
       ]);
   
       if ($validator->fails()) {
           return response()->json(
               [
                   "status"  => 401,
                   "message" => "Validation error",
                   "errors"  => $validator->errors(),
               ],
               403
           );
       }
   
       $userCode = $request->user_code;
       $targetValue = $request->target;
       $deadline = $request->date ?? $this->lastDayofMonth;
   
       // Check if the user already has a target for the current month
       $currentMonthTarget = VisitsTarget::where('user_code', $userCode)
           ->whereYear('Deadline', now()->year)
           ->whereMonth('Deadline', now()->month)
           ->first();
   
       if ($currentMonthTarget) {
           // Update the existing target for the current month
           $currentMonthTarget->update([
               'VisitsTarget' => $targetValue,
           ]);
   
           $responseTarget = $currentMonthTarget;
       } else {
           // Create a new target for the current month
           $createdTarget = VisitsTarget::create([
               'user_code' => $userCode,
               'Deadline'  => $deadline,
               'VisitsTarget' => $targetValue,
               'AchievedVisitsTarget' => 0,
           ]);
   
           $responseTarget = $createdTarget;
       }
   
       // Retrieve the user with the assigned target using 'user_code'
       $user = User::where('user_code', $userCode)->first();
   
       if ($user) {
           $action = "Assigning Visits Targets";
           $activity = "Visits Target assigned for the following user: " . $user->name;
   
           // Log the activity
           $this->activitylogs($action, $activity);
   
           return response()->json([
               "success"  => true,
               "status"   => 200,
               "message"  => "Target assigned successfully for the following user",
               "user"     => $user,        // Include user details in the response
               "visit_target"   => $responseTarget, // Include details of the assigned target in the response
           ]);
       }
   
       return response()->json([
           "status"  => 404,
           "message" => "User not found",
       ], 404);
   }
   
   

   public function assignLeadTarget(Request $request)
   {
       $validator = Validator::make($request->all(), [
           "user_code" => "required",
           "target"    => "required",
       ]);
   
       if ($validator->fails()) {
           return response()->json(
               [
                   "status"  => 401,
                   "message" => "Validation error",
                   "errors"  => $validator->errors(),
               ],
               403
           );
       }
   
       $userCode = $request->user_code;
       $targetValue = $request->target;
       $deadline = $request->date ?? $this->lastDayofMonth;
   
       // Check if the user already has a target for the current month
       $currentMonthTarget = LeadsTargets::where('user_code', $userCode)
           ->whereYear('Deadline', now()->year)
           ->whereMonth('Deadline', now()->month)
           ->first();
   
       if ($currentMonthTarget) {
           // Update the existing target for the current month
           $currentMonthTarget->update([
               'LeadsTarget' => $targetValue,
           ]);
   
           $responseTarget = $currentMonthTarget;
       } else {
           // Create a new target for the current month
           $createdTarget = LeadsTargets::create([
               'user_code' => $userCode,
               'Deadline'  => $deadline,
               'LeadsTarget' => $targetValue,
               'AchievedLeadsTarget' => 0,
           ]);
   
           $responseTarget = $createdTarget;
       }
   
       // Retrieve the user(s) with the assigned target using 'user_code'
       $users = User::whereIn('user_code', (array)$userCode)->get();
   
       if ($users->isNotEmpty()) {
           $userNames = $users->pluck('name')->implode(', ');
   
           $action = "Assigning Leads Targets";
           $activity = "Lead Targets assigned for the following users: " . $userNames;
   
           // Log the activity
           $this->activitylogs($action, $activity);
   
           return response()->json([
               "success"     => true,
               "status"      => 200,
               "message"     => "Target assigned successfully for the following users",
               "data"        => $users,           // Include user details in the response
               "lead_target" => $responseTarget, // Include details of the assigned target in the response
           ]);
       }
   
       return response()->json([
           "status"  => 404,
           "message" => "User not found",
       ], 404);
   }
   
   

   
   public function assignOrderTarget(Request $request)
   {
      $validator = Validator::make($request->all(), [
         "user_code" => "required",
         "target"    => "required",
      ]);

      if ($validator->fails()) {
         return response()->json(
               [
                  "status"  => 401,
                  "message" => "Validation error",
                  "errors"  => $validator->errors(),
               ],
               403
         );
      }

      $userCode = $request->user_code;
      $targetValue = $request->target;
      $deadline = $request->date ?? $this->lastDayofMonth;

      // Check if the user already has an order target for the current month
      $currentMonthTarget = OrdersTarget::where('user_code', $userCode)
         ->whereYear('Deadline', now()->year)
         ->whereMonth('Deadline', now()->month)
         ->first();

      if ($currentMonthTarget) {
         // Update the existing order target for the current month
         $currentMonthTarget->update([
               'OrdersTarget' => $targetValue,
         ]);

         $responseTarget = $currentMonthTarget;
      } else {
         // Create a new order target for the current month
         $createdTarget = OrdersTarget::create([
               'user_code' => $userCode,
               'Deadline'  => $deadline,
               'OrdersTarget' => $targetValue,
               'AchievedOrdersTarget' => 0,

         ]);

         $responseTarget = $createdTarget;
      }

      // Retrieve the user with the assigned target using 'user_code'
      $user = User::where('user_code', $userCode)->first();

      if ($user) {
         $action = "Assigning Orders Targets";
         $activity = "Orders Target assigned for the following user: " . $user->name;

         // Log the activity
         $this->activitylogs($action, $activity);

         return response()->json([
               "success"  => true,
               "status"   => 200,
               "message"  => "Target assigned successfully for the following user",
               "user"     => $user,        // Include user details in the response
               "order_target"   => $responseTarget, // Include details of the assigned target in the response
         ]);
      }

      return response()->json([
         "status"  => 404,
         "message" => "User not found",
      ], 404);
   }



   public function assignSaleTarget(Request $request)
   {
       $validator = Validator::make($request->all(), [
           "user_code" => "required",
           "target"    => "required",
       ]);
   
       if ($validator->fails()) {
           return response()->json(
               [
                   "status"  => 401,
                   "message" => "Validation error",
                   "errors"  => $validator->errors(),
               ],
               403
           );
       }
   
       $userCode = $request->user_code;
       $targetValue = $request->target;
       $deadline = $request->date ?? $this->lastDayofMonth;
   
       // Check if the user already has a sales target for the current month
       $currentMonthTarget = SalesTarget::where('user_code', $userCode)
           ->whereYear('Deadline', now()->year)
           ->whereMonth('Deadline', now()->month)
           ->first();
   
       if ($currentMonthTarget) {
           // Update the existing sales target for the current month
           $currentMonthTarget->update([
               'SalesTarget' => $targetValue,
           ]);
   
           $responseTarget = $currentMonthTarget;
       } else {
           // Create a new sales target for the current month
           $createdTarget = SalesTarget::create([
               'user_code' => $userCode,
               'Deadline'  => $deadline,
               'SalesTarget' => $targetValue,
               'AchievedSalesTarget' => 0,

           ]);
   
           $responseTarget = $createdTarget;
       }
   
       // Retrieve the user with the assigned target using 'user_code'
       $user = User::where('user_code', $userCode)->first();
   
       if ($user) {
           $action = "Assigning Sales Targets";
           $activity = "Sales Target assigned for the following user: " . $user->name;
   
           // Log the activity
           $this->activitylogs($action, $activity);
   
           return response()->json([
               "success"  => true,
               "status"   => 200,
               "message"  => "Target assigned successfully for the following user",
               "user"     => $user,        // Include user details in the response
               "sale_target"   => $responseTarget, // Include details of the assigned target in the response
           ]);
       }
   
       return response()->json([
           "status"  => 404,
           "message" => "User not found",
       ], 404);
   }
   
   public function activitylogs($activity,$action): void
   {
      $rdm = Str::random(20);
      $activityLog = new activity_log();
      $activityLog->source = 'Manager Mobile App';
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
