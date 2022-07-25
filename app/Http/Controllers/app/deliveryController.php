<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;
use Auth;
use Session;
class deliveryController extends Controller
{
   //index
   public function index(){
      return view('app.delivery.index');
   }

   //allocation
   public function allocation(Request $request){
      return 'working';
   }
}
