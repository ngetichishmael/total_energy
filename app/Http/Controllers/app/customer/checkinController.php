<?php

namespace App\Http\Controllers\app\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Session;

class checkinController extends Controller
{
   public function __construct()
   {
       $this->middleware('auth');
   }
   
   //checkin list
   public function index(){
      return view('app.checkins.index');
   }
}
