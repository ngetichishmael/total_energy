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
   
       // Update or create the visits target for the user
       VisitsTarget::updateOrCreate(
           [
               'user_code' => $userCode,
               'Deadline'  => $deadline,
           ],
           [
               'VisitsTarget' => $targetValue,
           ]
       );
   
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
               "Visit_target"   => $targetValue // Include assigned target in the response
           ]);
       }
   
       return response()->json([
           "status"  => 404,
           "message" => "User not found",
       ], 404);
   }
   

   public function assignLeadTarget(Request $request)
   {
      $validator           =  Validator::make($request->all(), [
         "user_code"   => "required",
         "target"   => "required",
      ]);
      if ($validator->fails()) {
         return response()->json(
            [
               "status" => 401, "message" => "validation_error",
               "errors" => $validator->errors()
            ],
            403
         );
      }
      LeadsTargets::updateOrCreate(
         [
            'user_code' => $request->user_code,
            'Deadline' =>  $request->date ?? $this->lastDayofMonth,
         ],
         [
            'LeadsTarget' => $request->target,
//            'bussiness_code' => $request->user()->business_code,
         ]
      );
      $users=User::find($request->user_code);
      $list=[];
      foreach ($users as $user){
         $list=$user->name;
      }
      $action="Assigning Leads Targets";
      $activity="Lead Targets assigned for the following users ".$list;
      $this->activitylogs($action, $activity);
      return response()->json([
         "success" => true,
         "status" => 200,
         "message" => "Target assigned for the following users ",
         "data" =>$users,
      ]);
   }
   public function assignOrderTarget(Request $request)
   {
      $validator           =  Validator::make($request->all(), [
         "user_code"   => "required",
         "target"   => "required",
      ]);
      if ($validator->fails()) {
         return response()->json(
            [
               "status" => 401, "message" => "validation_error",
               "errors" => $validator->errors()
            ],
            403
         );
      }
      OrdersTarget::updateOrCreate(
         [
            'user_code' => $request->user_code,
            'Deadline' => $request->date ?? $this->lastDayofMonth,

         ],
         [
            'OrdersTarget' => $request->target,
//            'bussiness_code' => $request->user()->business_code,
         ]
      );
      $users=User::find($request->user_code);
      $list=[];
      foreach ($users as $user){
         $list=$user->name;
      }
      $action="Assigning Orders Targets";
      $activity="Orders Target assigned for the following user ".$list;
      $this->activitylogs($action, $activity);
      return response()->json([
         "success" => true,
         "status" => 200,
         "message" => "Target assigned for the following users",
         "data" => User::find($request->user_code),
      ]);
   }
   public function assignSaleTarget(Request $request)
   {
      $validator =  Validator::make($request->all(), [
         "user_code"   => "required",
         "target"   => "required",
      ]);
      if ($validator->fails()) {
         return response()->json(
            [
               "status" => 401, "message" => "validation_error",
               "errors" => $validator->errors()
            ],
            403
         );
      }
      SalesTarget::updateOrCreate(
         [
            'user_code' =>  $request->user_code,
            'Deadline' => $request->date ?? $this->lastDayofMonth,
         ],
         [
            'SalesTarget' => $request->target,
//            'bussiness_code' => $request->user()->business_code,
         ]
      );
      $users=User::find($request->user_code);
      $list=[];
      foreach ($users as $user){
         $list=$user->name;
      }
      $action="Assigning Sales Targets";
      $activity="Sales Target assigned for the following user ".$list;
      $this->activitylogs($action, $activity);
      return response()->json([
         "success" => true,
         "status" => 200,
         "message" => "Target assigned for the following users",
         "data" => $users,
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
