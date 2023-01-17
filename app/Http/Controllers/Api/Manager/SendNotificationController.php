<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SendNotificationController extends Controller
{
   public function receiveNotification(Request $request)
   {
      $data = $request->all();
      $users= $data["users"];
      $phone=[];
      foreach($users as $user){
         $phone[$user["user_code"]] = User::where("user_code",$user["user_code"])->pluck('phone_number')->first();
      }
      return response()->json([
         "success" => true,
         "status" => 200,
         "phone" => $phone,
      ]);
   }
}
