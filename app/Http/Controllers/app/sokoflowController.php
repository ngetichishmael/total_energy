<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\order_payments as OrderPayment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class sokoflowController extends Controller
{

    /**
     * dashboard controller instance.
     */
    public function dashboard()
    {

        // if (Auth::user()->account_type === 'Admin') {

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
        $activeUser = DB::table('users')
            ->whereDate('created_at', Carbon::today())
            ->count();
        $activeAll = User::where('account_type', 'Sales')->count();
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

        // } else{

        //    $today = Carbon::today();
        //    $week = Carbon::now()->subWeeks(1);
        //    $month = Carbon::now()->subMonth(1);
        //    $year = Carbon::now()->subYears(1);

        //    $daily = DB::table('order_payments')
        //       ->whereDate('created_at', $today)
        //       ->sum('amount');
        //    $weekly = DB::table('order_payments')
        //       ->whereBetween('created_at', [$week, $today])
        //       ->sum('amount');
        //    $monthly = DB::table('order_payments')
        //       ->whereBetween('created_at', [$week, $today])
        //       ->sum('amount');
        //    $sumAll = DB::table('order_payments')
        //       ->sum('amount');
        //    $vansales = Orders::where('order_type', 'Van sales')
        //       ->where('order_status', 'DELIVERED')
        //       ->sum('price_total');
        //    $preorder = Orders::where('order_type', 'Pre Order')
        //       ->where('order_status', 'DELIVERED')
        //       ->sum('price_total');
        //    $orderfullment = Orders::where('order_status', 'DELIVERED')
        //       ->count();
        //    $activeUser = DB::table('customer_checkin')
        //       ->distinct('user_code')
        //       ->whereDate('created_at', Carbon::today())
        //       ->count();
        //    $activeAll = User::where('account_type', 'Sales')->count();
        //    $sales = DB::table('order_payments')
        //       ->select('id', 'amount', 'balance', 'payment_method', 'isReconcile', 'user_id')
        //       ->where('user_id', auth()->id())->sum('balance');

        //    $cash = OrderPayment::where('payment_method', 'PaymentMethods.Cash')->sum('amount');
        //    $mpesa = OrderPayment::where('payment_method', 'PaymentMethods.Mpesa')->sum('amount');
        //    $cheque = OrderPayment::where('payment_method', 'PaymentMethods.Cheque')->sum('amount');

        //    $strike = DB::table('customer_checkin')->whereDate('created_at', Carbon::today())->count();
        //    $customersCount = Orders::distinct('customerID')->whereDate('created_at', Carbon::today())->count();

        //    return view('app.distributor.dashboard', [
        //       'Cash' => $cash,
        //       'Mpesa' => $mpesa,
        //       'Cheque' => $cheque,
        //       'sales' => $sales,
        //       'total' => $cash + $cheque + $mpesa,
        //       'vansales' => $vansales,
        //       'preorder' => $preorder,
        //       'orderfullment' => $orderfullment,
        //       'activeUser' => $activeUser,
        //       'activeAll' => $activeAll,
        //       'daily' => $daily,
        //       'weekly' => $weekly,
        //       'monthly' => $monthly,
        //       'sumAll' => $sumAll,
        //       'strike' => $strike,
        //       'customersCount' => $customersCount
        //    ]);

        // }

    }
    //user summary
    public function user_summary()
    {
        return view('app.dashboard.user-summary');
    }
}
