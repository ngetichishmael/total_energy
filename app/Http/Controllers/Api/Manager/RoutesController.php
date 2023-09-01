<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Routes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoutesController extends Controller
{
   public function getRoutes(Request $request)
   {
      $arrayData = [];
      $authenticatedUserRouteCode = Auth::user()->route_code;
      
      $datas = Routes::whereHas('user', function ($query) use ($authenticatedUserRouteCode) {
          $query->where('route_code', $authenticatedUserRouteCode);
      })
      ->withCount(['RouteSales'])
      ->with('RouteSales.User')
      ->get();
   
       foreach ($datas as $value) {
           $data["id"] = $value["id"];
           $data["name"] = $value["name"];
           $data["status"] = $value["status"];
           $data["Type"] = $value["Type"];
           $data["start_date"] = $value["start_date"];
           $data["end_date"] = $value["end_date"];
           $data["created_by_route_code"] = (int) $value->user->route_code; // Convert to integer
           $data["users_count"] = 0;
           $data["users"] = [];
   
           foreach ($value->RouteSales as $values) {
               $data["users_count"] = count($values->User);
               if (count($values->User) > 0) {
                   $userArray = [];
                   foreach ($values->User as $user) {
                       $userArray[] = [
                           'id' => $user->id,
                           'name' => $user->name,
                           'user_code' => $user->user_code,
                           'email' => $user->email,
                           'location' => $user->location,
                           'fcm_token' => $user->fcm_token,
                       ];
                   }
                   $data["users"] = $userArray;
               } else {
                   $data["users"] = $this->emptyFilterUsers();
               }
           }
   
           array_push($arrayData, $data);
       }
   
       return response()->json([
           'status' => 200,
           'success' => true,
           "message" => "Routes data",
           'data' => $arrayData,
       ]);
   }
   
   

   public function filterUsers($data)
   {
       $userData = []; // Changed the variable name
       if ($data !== null) {
           $userData["id"] = $data["id"];
           $userData["name"] = $data["name"];
           $userData["user_code"] = $data["user_code"];
           $userData["email"] = $data["email"];
           $userData["location"] = $data["location"];
           $userData["fcm_token"] = $data["fcm_token"];
       }
       return $userData; // Return the user data array
   }
   
   public function emptyFilterUsers()
   {
       $arrayData = [];
       $arrayData[] = [
           "id" => 0,
           "name" => "No Sales Associate",
           "user_code" => "No Sales Associate",
           "email" => "No Sales Associate",
           "location" => "No Sales Associate",
           "fcm_token" => "No Sales Associate"
       ];
       return $arrayData;
   }
   
}
