<?php

namespace App\Http\Controllers\app;

use App\Charts\BrandSales;
use App\Charts\CatergoryChart;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\order_payments as OrderPayment;
use App\Models\Orders;
use App\Models\User;
use Carbon\Carbon;

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
   public function dashboard()
   {

      $today = Carbon::today();
      $week = Carbon::now()->subWeeks(1);
      $month = Carbon::now()->subMonth(1);
      $year = Carbon::now()->subYears(1);

      $daily = DB::table('order_payments')
         ->whereDate('created_at', $today)
         ->sum('amount');
      $weekly = DB::table('order_payments')
         ->whereBetween('created_at', [$week, $today])
         ->sum('amount');
      $monthly = DB::table('order_payments')
         ->whereBetween('created_at', [$week, $today])
         ->sum('amount');
      $sumAll = DB::table('order_payments')
         ->sum('amount');
      $vansales = Orders::where('order_type', 'Van sales')
         ->where('order_status', 'DELIVERED')
         ->sum('price_total');
      $preorder = Orders::where('order_type', 'Pre Order')
         ->where('order_status', 'DELIVERED')
         ->sum('price_total');
      $orderfullment = Orders::where('order_status', 'DELIVERED')
         ->count();
      $activeUser = DB::table('customer_checkin')
         ->distinct('user_code')
         ->whereDate('created_at', Carbon::today())
         ->count();
      $activeAll = User::where('account_type', 'Sales')->count();
      $brands = DB::table('order_items')->select('product_name', DB::raw('SUM(total_amount) as total'))
         ->groupBy('product_name')
         ->orderBy('total', 'desc')
         ->limit(7)
         ->get();
      $catergories = DB::table('order_items')->select('product_name', DB::raw('SUM(total_amount) as total'))
         ->groupBy('product_name')
         ->orderBy('total', 'asc')
         ->limit(7)
         ->get();
      $arrayLabel = [];
      $arrayData = [];
      $arrayCLabel = [];
      $arrayCData = [];
      foreach ($brands as $br) {
         array_push($arrayLabel, $br->product_name);
         array_push($arrayData, $br->total);
      }
      foreach ($catergories as $br) {
         array_push($arrayCLabel, $br->product_name);
         array_push($arrayCData, $br->total);
      }
      $brandsales = new BrandSales();
      $brandsales->labels($arrayLabel);
      $brandsales->dataset('Best Perfom Brand', 'bar', $arrayData)->options([
         "responsive" => true,
         'color' => "#94DB9D",
         'backgroundColor' => '#35827b',
         "borderWidth" => 2,
         "borderRadius" => 5,
         "borderSkipped" => false,
      ]);

      $catergories = new CatergoryChart();
      $catergories->labels($arrayCLabel);
      $catergories->dataset('Least Perfom Brand', 'bar', $arrayCData)->options([
         "responsive" => true,
         'color' => "#94DB9D",
         'backgroundColor' => '#f07f21',
         "borderWidth" => 2,
         "borderRadius" => 5,
         "borderSkipped" => false,
      ]);

      $sales = DB::table('order_payments')
         ->select('id', 'amount', 'balance', 'payment_method', 'isReconcile', 'user_id')
         ->where('user_id', auth()->id())->sum('balance');

      $cash = OrderPayment::where('payment_method', 'PaymentMethods.Cash')->sum('amount');
      $mpesa = OrderPayment::where('payment_method', 'PaymentMethods.Mpesa')->sum('amount');
      $cheque = OrderPayment::where('payment_method', 'PaymentMethods.Cheque')->sum('amount');

      $strike = DB::table('customer_checkin')->whereDate('created_at', Carbon::today())->count();
      $customersCount = Orders::distinct('customerID')->whereDate('created_at', Carbon::today())->count();

      return view('app.dashboard.dashboard', [
         'Cash' => $cash,
         'Mpesa' => $mpesa,
         'Cheque' => $cheque,
         'sales' => $sales,
         'total' => $cash + $cheque + $mpesa,
         'brandsales' => $brandsales,
         'catergories' => $catergories,
         'vansales' => $vansales,
         'preorder' => $preorder,
         'orderfullment' => $orderfullment,
         'activeUser' => $activeUser,
         'activeAll' => $activeAll,
         'daily' => $daily,
         'weekly' => $weekly,
         'monthly' => $monthly,
         'sumAll' => $sumAll,
         'strike' => $strike,
         'customersCount' => $customersCount,
      ]);

      // return view('app.dashboard.dashboard',compact('Cash', 'Mpesa','Cheque','reconciled','total'));
   }

   //user summary
   public function user_summary()
   {
      return view('app.dashboard.user-summary');
   }
}
