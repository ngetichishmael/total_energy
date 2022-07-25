<?php

namespace App\Http\Controllers\app\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class checkinController extends Controller
{
   //checkin list
   public function index(){
      return view('app.checkins.index');
   }
}
