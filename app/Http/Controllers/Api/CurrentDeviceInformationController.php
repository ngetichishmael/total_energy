<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CurrentDeviceInformation;
use Illuminate\Http\Request;

class CurrentDeviceInformationController extends Controller
{
    public function postCurrentDeviceInformation(Request $request)
    {

      CurrentDeviceInformation::create(
         [
            "user_code"=>$request->user()->user_code,
            "current_gps"=>$request->current_gps,
            "current_battery_percentage"=>$request->current_battery_percentage,
            "device_code"=>$request->device_code,
            "IMEI"=>$request->IMEI,
            "fcm_token"=>$request->fcm_token,
            "android_version"=>$request->android_version
         ]
      );

      return response()->json([
         "success" => true,
         "message" => "Data posted successfully",
      ]);
    }
}