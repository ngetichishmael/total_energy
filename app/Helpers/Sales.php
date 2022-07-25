<?php
namespace App\Helpers;

use App\Models\inventory\allocations;
use App\Models\inventory\items;
use App\Models\Territory;
use App\Models\User;
use Auth;

class Sales{

   //========================================Territory  ==========================================
	//=============================================================================================

   //child territory
   public static function child_territory($code){
      $child = Territory::where('parent_code',$code)->orderby('id','desc')->get();
      return $child;
   }

   //======================================== inventory ==========================================
	//=============================================================================================
   //total allocated items
   public static function total_allocated_items($code){
      $total = items::where('allocation_code',$code)->where('business_code',Auth::user()->business_code)->get();
      return $total;
   }



   //======================================== General  ==========================================
	//=============================================================================================
   public static function user($userCode){
      $user = User::where('user_code',$userCode)->first();
      return $user;
   }

}
