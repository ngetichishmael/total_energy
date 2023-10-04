<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TargetResource;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TargetsController extends Controller
{

    // public function getSalespersonTarget(Request $request)
    // {
    //    $user_code = $request->user()->user_code;
    //    $target = User::with('TargetSale', 'TargetLead', 'TargetsOrder', 'TargetsVisit')
    //       ->where('user_code', $user_code)->first();
    //    return response()->json([
    //       "success" => true,
    //       "message" => "Target Set",
    //       "Targets" => new TargetResource($target),
    //    ]);
    // }

   public function getSalespersonTarget(Request $request)
   {
       $user_code = $request->user()->user_code;
       $currentMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
   
       $target = User::with([
           'TargetSale' => function ($query) use ($currentMonth) {
               $query->where('Deadline', 'LIKE', substr($currentMonth, 0, 7) . '%');
           },
           'TargetLead' => function ($query) use ($currentMonth) {
               $query->where('Deadline', 'LIKE', substr($currentMonth, 0, 7) . '%');
           },
           'TargetsOrder' => function ($query) use ($currentMonth) {
               $query->where('Deadline', 'LIKE', substr($currentMonth, 0, 7) . '%');
           },
           'TargetsVisit' => function ($query) use ($currentMonth) {
               $query->where('Deadline', 'LIKE', substr($currentMonth, 0, 7) . '%');
           },
       ])
       ->where('user_code', $user_code)
       ->first();
   
       return response()->json([
           "success" => true,
           "message" => "Target Set",
           "Targets" => new TargetResource($target),
       ]);
   }
   
}
