<?php

namespace App\Http\Controllers\app;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\order_payments as OrderPayment;

class sokoflowController extends Controller
{
   /**
   * Create a new controller instance.
   *
   * @return void
   */
   public function __construct()
   {
      // $this->middleware('auth');
   }


   /**
   * dashboard controller instance.
   */
   public function dashboard(){
      // $orders = order_payments::all();

      $Cash=OrderPayment::where('payment_method','PaymentMethods.Mpesa')->sum('amount');
      $Mpesa=OrderPayment::where('payment_method','PaymentMethods.Cash')->sum('amount');
      $Cheque=OrderPayment::where('payment_method','PaymentMethods.Cheque')->sum('amount');
      $reconciled=OrderPayment::where('isReconcile','true')->count('amount');
      $total=OrderPayment::sum('amount');
      $Cash = $Cash ?? 'No Cash Collected'; 
      $Mpesa = $Mpesa ?? 'No Mpesa Collected'; 
      $Cheque = $Cheque ?? 'No Cheque Collected'; 
      $total = $total ?? 'No Total Collected'; 

      return view('app.dashboard.dashboard',compact('Cash', 'Mpesa','Cheque','reconciled','total'));
   }

   //user summary
   public function user_summary(){
      return view('app.dashboard.user-summary');
   }
}
