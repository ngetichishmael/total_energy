<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\inventory\allocations;
use Illuminate\Http\Request;
use Helper;
use Session;
use Auth;

class inventoryController extends Controller
{
   //allocated
   public function allocated(){
      return view('app.inventory.allocated');
   }

   //allocate user
   public function allocate_user(Request $request){
      $code = Helper::generateRandomString(20);
      $item = new allocations;
      $item->business_code = Auth::user()->business_code;
      $item->allocation_code = $code;
      $item->sales_person = $request->sales_person;
      $item->date_allocated = date("Y-m-d");
      $item->status = 'Waiting acceptance';
      $item->created_by = Auth::user()->user_code;
      $item->save();

      Session::flash('success','Allocate products to sales person');

      return redirect()->route('inventory.allocate.items',$code);
   }

   //allocate items
   public function allocate_items($code){
      return view('app.inventory.allocate_items', compact('code'));
   }
}
