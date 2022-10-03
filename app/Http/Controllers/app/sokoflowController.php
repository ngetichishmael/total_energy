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
      // $Cash=OrderPayment::where('payment_method','PaymentMethods.Mpesa')->sum('amount');
      // $Mpesa=OrderPayment::where('payment_method','PaymentMethods.Cash')->sum('amount');
      // $Cheque=OrderPayment::where('payment_method','PaymentMethods.Cheque')->sum('amount');
      // $reconciled=OrderPayment::where('isReconcile','true')->count('amount');
      // $total=OrderPayment::sum('amount');
      // $Cash = $Cash ?? 'No Cash Collected';
      // $Mpesa = $Mpesa ?? 'No Mpesa Collected';
      // $Cheque = $Cheque ?? 'No Cheque Collected';
      // $total = $total ?? 'No Total Collected';

      return view('app.dashboard.dashboard', [

         $item = DB::table('order_payments')
         ->select('id', 'amount', 'balance', 'payment_method', 'isReconcile' ,'user_id')
         ->where('user_id', auth()->id())->where('payment_method', 'PaymentMethods.Cash')->sum('amount'),
         $item1 = DB::table('order_payments')
         ->select('id', 'amount', 'balance', 'payment_method', 'isReconcile' ,'user_id')
         ->where('user_id', auth()->id())->where('payment_method', 'PaymentMethods.Mpesa')->sum('amount'),
         $item2 = DB::table('order_payments')
         ->select('id', 'amount', 'balance', 'payment_method', 'isReconcile' ,'user_id')
         ->where('user_id', auth()->id())->where('payment_method', 'PaymentMethods.Cheque')->sum('amount'),
         $sales = DB::table('order_payments')
         ->select('id', 'amount', 'balance', 'payment_method', 'isReconcile' ,'user_id')
         ->where('user_id', auth()->id())->sum('balance'),
         $total = DB::table('order_payments')
         ->select('id', 'amount', 'balance', 'payment_method', 'isReconcile' ,'user_id')
         ->where('user_id', auth()->id())->sum('amount'),
         'Cash' => $item,
         'Mpesa' => $item1,
         'Cheque' => $item2,
         'sales' => $sales,
         'total' => $total,
         'Reconcilled' => 'null']);

      // return view('app.dashboard.dashboard',compact('Cash', 'Mpesa','Cheque','reconciled','total'));
   }

   //user summary
   public function user_summary(){
      return view('app.dashboard.user-summary');
   }
}
