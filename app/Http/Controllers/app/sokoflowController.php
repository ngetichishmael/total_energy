<?php

namespace App\Http\Controllers\app;

use App\Models\business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\order_payments;

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
   public function dashboard(order_payments $order){
      // $orders = order_payments::all();

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
         $total = DB::table('order_payments')
         ->select('id', 'amount', 'balance', 'payment_method', 'isReconcile' ,'user_id')
         ->where('user_id', auth()->id())->sum('amount'),
         // ddd($item),
         'Cash' => $item,
         'Mpesa' => $item1,
         'Cheque' => $item2,
         'total' => $total,
         'Reconcilled' => $order,

     ]);
   }

   //user summary
   public function user_summary(){
      return view('app.dashboard.user-summary');
   }
}
