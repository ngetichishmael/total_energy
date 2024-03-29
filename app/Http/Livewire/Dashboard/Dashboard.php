<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\AssignedRegion;
use App\Models\customers;
use App\Models\customer\checkin;
use App\Models\Delivery;
use App\Models\Orders;
use App\Models\order_payments as OrderPayment;
use App\Models\products\product_information;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $start;
    public $end;
    public $daily;
    public $weekly;
    public $monthly;
    public $sumAll;
    public $perVansale = 10;
    public $perPreorder = 10;
    public $perBuyingCustomer = 10;
    public $perVisits = 10;
    public $perOrderFulfilment = 10;
    public $perActiveUsers = 10;
    public $perUserTotal = 10;
    public $userRegion;

    // Individual functions for data retrieval

    public function whereBetweenDate(Builder $query, string $column = null, string $start = null, string $end = null): Builder
    {
        if (is_null($start) && is_null($end)) {
            return $query;
        }

        if (!is_null($start) && Carbon::parse($start)->isSameDay(Carbon::parse($end))) {
            return $query->where($column, '=', $start);
        }
        $end = $end == null ? Carbon::now()->endOfMonth()->format('Y-m-d') : $end;
        return $query->whereBetween($column, [$start, $end]);
    }
    public function getCashAmount()
    {
        $query = OrderPayment::where('payment_method', 'PaymentMethods.Cash');

        if (empty($this->start) && empty($this->end)) {
            $currentMonth = now()->startOfMonth();
            $query->whereBetween('updated_at', [$currentMonth, now()]);
        } else {
            if (!empty($this->start)) {
                $query->where('updated_at', '>=', $this->start);
            }
            if (!empty($this->end)) {
                $query->where('updated_at', '<=', $this->end);
            }
        }

        return $query->sum('amount');
    }

    public function getMpesaAmount()
    {
        $query = OrderPayment::where('payment_method', 'PaymentMethods.Mpesa');

        if (empty($this->start) && empty($this->end)) {
            $currentMonth = now()->startOfMonth();
            $query->whereBetween('updated_at', [$currentMonth, now()]);
        } else {
            if (!empty($this->start)) {
                $query->where('updated_at', '>=', $this->start);
            }
            if (!empty($this->end)) {
                $query->where('updated_at', '<=', $this->end);
            }
        }

        return $query->sum('amount');
    }

    public function getChequeAmount()
    {
        $query = OrderPayment::where('payment_method', 'PaymentMethods.Cheque');

        if (empty($this->start) && empty($this->end)) {
            $currentMonth = now()->startOfMonth();
            $query->whereBetween('updated_at', [$currentMonth, now()]);
        } else {
            if (!empty($this->start)) {
                $query->where('updated_at', '>=', $this->start);
            }
            if (!empty($this->end)) {
                $query->where('updated_at', '<=', $this->end);
            }
        }

        return $query->sum('amount');
    }

    public function getSalesAmount()
    {
        return OrderPayment::where(function (Builder $query) {
            $this->whereBetweenDate($query, 'created_at', $this->start, $this->end);
        })
            ->select('id', 'amount', 'balance', 'payment_method', 'isReconcile', 'user_id')
            ->sum('balance');
    }

    public function getTotalAmount()
    {
        $query = OrderPayment::where('payment_method', 'PaymentMethods.BankTransfer');

        if (empty($this->start) && empty($this->end)) {
            $currentMonth = now()->startOfMonth();
            $query->whereBetween('created_at', [$currentMonth, now()]);
        } else {
            if (!empty($this->start)) {
                $query->where('created_at', '>=', $this->start);
            }
            if (!empty($this->end)) {
                $query->where('created_at', '<=', $this->end);
            }
        }

        return $query->sum('amount');
    }

    public function getVanSales()
    {
        $user = Auth::user();

        // Check the user's account type
        if ($user->account_type === 'Admin') {
            $query = Orders::where('order_type', 'Van sales');
        } else {
            $assignedRegions = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id');

            $assignedCustomerIds = customers::whereHas('area.subregion.region', function ($query) use ($assignedRegions) {
                $query->whereIn('id', $assignedRegions);
            })->pluck('id');

            $query = Orders::whereIn('customerID', $assignedCustomerIds)
                ->where('order_type', 'Van sales');
        }

        if (empty($this->start) && empty($this->end)) {
            $currentMonth = Carbon::now()->startOfMonth();
            $query->whereBetween('created_at', [$currentMonth, Carbon::now()]);
        } else {
            if (!empty($this->start)) {
                $query->where('created_at', '>=', $this->start);
            }
            if (!empty($this->end)) {
                $query->where('created_at', '<=', $this->end);
            }
        }

        return $query->count();
    }

    public function getPreOrderCount()
    {
        $user = Auth::user();

        // Check the user's account type
        if ($user->account_type === 'Admin') {
            $query = Orders::where('order_type', 'Pre Order');
        } else {
            $assignedRegions = AssignedRegion::where('user_code', $user->user_code)->pluck('region_id');

            $assignedCustomerIds = customers::whereHas('area.subregion.region', function ($query) use ($assignedRegions) {
                $query->whereIn('id', $assignedRegions);
            })->pluck('id');

            $query = Orders::whereIn('customerID', $assignedCustomerIds)
                ->where('order_type', 'Pre Order');
        }

        if (empty($this->start) && empty($this->end)) {
            $currentMonth = Carbon::now()->startOfMonth();
            $query->whereBetween('created_at', [$currentMonth, Carbon::now()]);
        } else {
            if (!empty($this->start)) {
                $query->where('created_at', '>=', $this->start);
            }
            if (!empty($this->end)) {
                $query->where('created_at', '<=', $this->end);
            }
        }

        return $query->count();

    }

    public function getOrderFullmentByDistributorsCount()
    {
        return Orders::where('order_status', 'LIKE', '%deliver%')
            ->where('order_type', 'Pre Order')
            ->where(function (Builder $query) {
                $this->whereBetweenDate($query, 'created_at', $this->start, $this->end);
            })
            ->count();
    }

    public function getOrderFullmentByDistributorsPage()
    {

        return Orders::with('Customer', 'user')
            ->where('order_status', 'LIKE', '%deliver%')
            ->where('order_type', 'Pre Order')
            ->where(function (Builder $query) {
                $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
            })
            ->paginate($this->perPreorder);
    }

    public function getOrderFullmentCount()
    {

        return Delivery::where('delivery_status', 'LIKE', '%deliver%')
            ->where(function (Builder $query) {
                $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
            })
            ->count();
    }

    public function getActiveUserCount()
    {
        return User::where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
        })
            ->count();
    }

    public function getActiveAllCount()
    {
        return User::where('account_type', '!=', 'Customer')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->count();
    }

    public function getStrikeCount()
    {
        // Check if start and end dates are not set, then set them to the current month
        if (empty($this->start) || empty($this->end)) {
            $this->start = now()->startOfMonth();
            $this->end = now()->endOfMonth();
        }

        return checkin::where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
        })
            ->count();
    }

    public function getCustomersCount()
    {

        $query = Customers::query();

        if (empty($this->start) && empty($this->end)) {
            $currentMonth = Carbon::now()->startOfMonth();
            $query->whereBetween('created_at', [$currentMonth, Carbon::now()]);
        } else {
            if (!empty($this->start)) {
                $query->where('created_at', '>=', $this->start);
            }
            if (!empty($this->end)) {
                $query->where('created_at', '<=', $this->end);
            }
        }

        return $query->count();

    }

    public function getLatestSales()
    {
        return Orders::with('User', 'Customer')
            ->where('order_status', 'DELIVERED')
            ->whereHas('Customer')
            ->whereHas('User')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->paginate($this->perVansale);
    }

    public function getPreOrderTotal()
    {
        return Orders::with('User', 'Customer')
            ->where('order_type', 'Pre Order')
            ->where(function (Builder $query) {
                $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
            })
            ->whereHas('Customer')
            ->whereHas('User')
            ->paginate($this->perPreorder);
    }

    public function getActiveUserTotal()
    {
        return checkin::with('User', 'Customer')
            ->distinct('user_code')
            ->groupBy('user_code')
            ->where(function (Builder $query) {
                $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
            })
            ->paginate($this->perActiveUsers);
    }
    public function getUserTotal()
    {
        return User::where('account_type', '!=', 'Customer')->with('Region')
            ->where(function (Builder $query) {
                $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
            })
            ->paginate($this->perUserTotal);
    }
    public function getOrderFullmentTotal()
    {
        return Orders::with('User', 'Customer', 'deliveries')
            ->where('order_status', 'DELIVERED')
            ->whereHas('User')
            ->whereHas('Customer')
            ->latest('updated_at') // Sort by 'updated_at' in descending order (most recent first)
            ->paginate($this->perOrderFulfilment);
    }

    public function deliveryCount()
    {

        $currentMonth = Carbon::now()->format('m');

        return Orders::where('order_type', 'Pre Order')
            ->where('order_status', 'DELIVERED')
            ->whereMonth('delivery_date', $currentMonth)
            ->count();

    }

    public function getVisitsTotal()
    {
        return checkin::with('User', 'Customer')
            ->groupBy('customer_id')
            ->where(function (Builder $query) {
                $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
            })
            ->paginate($this->perVisits);
    }

    public function getCustomersCountTotal()
    {
        return customers::with('Area', 'Creator')
            ->whereHas('Area')
            ->whereHas('Creator')
            ->orderBy('created_at', 'desc') // Order by the most recent (created_at in descending order)
            ->paginate($this->perBuyingCustomer);
    }

    public function getTopDeliveredProducts()
    {
        return product_information::select(
            'product_information.product_name',
            'product_information.sku_code',
            DB::raw('SUM(delivery_items.delivery_quantity) as total_quantity')
        )
            ->leftJoin('delivery_items', 'product_information.id', '=', 'delivery_items.productID')
            ->groupBy('product_information.id')
            ->orderByDesc('total_quantity')
            ->take(6)
            ->get();
    }

    public function getGraphData()
    {
        $months = [
            1 => 'Jan',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
        $preOrderCounts = Orders::where('order_type', 'Pre Order')
            ->whereYear('updated_at', '=', date('Y'))
            ->selectRaw('MONTH(updated_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
        $deliveryCounts = Delivery::where('delivery_status', 'DELIVERED')
            ->whereYear('updated_at', '=', date('Y'))
            ->selectRaw('MONTH(updated_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $graphdata = [];
        for ($month = 1; $month <= 12; $month++) {
            $graphdata[] = [
                'month' => $months[$month],
                'preOrderCount' => $preOrderCounts[$month] ?? $month++,
                'deliveryCount' => $deliveryCounts[$month] ?? $month++,
            ];
        }
        return $graphdata;
    }
    public function render()
    {

        $data = [
            'Cash' => $this->getCashAmount(),
            'Mpesa' => $this->getMpesaAmount(),
            'Cheque' => $this->getChequeAmount(),
            'total' => $this->getTotalAmount(),
            'vansales' => $this->getVanSales(),
            'preorder' => $this->getPreOrderCount(),
            'orderfullmentbydistributors' => $this->getOrderFullmentByDistributorsCount(),
            'orderfullmentbydistributorspage' => $this->getOrderFullmentByDistributorsPage(),
            'orderfullment' => $this->getOrderFullmentCount(),
            'activeUser' => $this->getActiveUserCount(),
            'activeAll' => $this->getActiveAllCount(),
            'strike' => $this->getStrikeCount(),
            'customersCount' => $this->getCustomersCount(),
            'sales' => $this->getLatestSales(),
            'preorderTotal' => $this->getPreOrderTotal(),
            'activeUserTotal' => $this->getActiveUserTotal(),
            'getUserTotal' => $this->getUserTotal(),
            'orderfullmentTotal' => $this->getOrderFullmentTotal(),
            'visitsTotal' => $this->getVisitsTotal(),
            'customersCountTotal' => $this->getCustomersCountTotal(),
            'deliveryCount' => $this->deliveryCount(),
            'graphdata' => $this->getGraphData(),
            'topproducts' => $this->getTopDeliveredProducts(),

        ];

        return view('livewire.dashboard.dashboard', $data);
    }

    public function mount()
    {
        $today = Carbon::today();
        $week = Carbon::now()->subWeeks(1);

        $this->daily = DB::table('order_payments')
            ->whereDate('created_at', $today)
            ->sum('amount');
        $this->weekly = DB::table('order_payments')
            ->whereBetween('created_at', [$week, $today])
            ->sum('amount');
        $this->monthly = DB::table('order_payments')
            ->whereBetween('created_at', [$week, $today])
            ->sum('amount');
        $this->sumAll = DB::table('order_payments')
            ->sum('amount');

        $user = Auth::user();

        if ($user) {
            $this->userRegion = $user->Region->name ?? "General"; // Assuming 'Region' is the relationship
        }
    }
    public function updatedStart()
    {
        $this->changes();
    }
    public function updatedEnd()
    {
        $this->changes();
    }
    public function changes()
    {
        $this->mount();
        $this->render();
        $this->getCashAmount();
        $this->getMpesaAmount();
        $this->getChequeAmount();
        $this->getSalesAmount();
        $this->getTotalAmount();
        $this->getVanSales();
        $this->getPreOrderCount();
        $this->getOrderFullmentByDistributorsCount();
        $this->getOrderFullmentByDistributorsPage();
        $this->getOrderFullmentCount();
        $this->getActiveUserCount();
        $this->getActiveAllCount();
        $this->getStrikeCount();
        $this->getCustomersCount();
        $this->deliveryCount();
        $this->getPreOrderTotal();
        $this->getActiveUserTotal();
        $this->getUserTotal();
        $this->getOrderFullmentTotal();
        $this->getVisitsTotal();
        $this->getCustomersCountTotal();
        $this->getGraphData();
        $this->getTopDeliveredProducts();
    }
}
