<?php

namespace App\Http\Controllers\app;

use Auth;
use Session;
use App\Models\User;
use App\Models\Orders;
use App\Models\Delivery;
use App\Models\customers;
use App\Models\Order_items;
use Illuminate\Http\Request;
use App\Models\order_payments;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class deliveryController extends Controller
{

   public function index()
   {
      return view('app.delivery.index');
   }
   public function details($code)
   {
      $total=0;
      $subtotal=0;
      $deliveries = Delivery::with('User','OrderItems')
         ->where('order_code',$code)
         ->select('*')
         ->limit(1)
         ->get();
      return view('app.delivery.invoice', compact('deliveries', 'code','total','subtotal'));
   }
}
