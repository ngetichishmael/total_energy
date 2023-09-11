<?php

namespace App\Http\Livewire\Orders;

use App\Exports\OrdersExport;
use App\Models\Delivery;
use App\Models\Orders;
use App\Models\suppliers\suppliers;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Pendingdeliveries extends Component
{
  

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 15;
    public $search = null;
    public $orderBy = 'orders.id';
    public $orderAsc = false;
    public $customer_name = null;

    public $start;
    public $end;

    public $fromDate;
    public $toDate;

    protected $queryString = ['search', 'fromDate', 'toDate'];
    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $sokoflow = suppliers::where('name', 'MarkG')->first();

        $orders = Orders::with('Customer', 'user')
        ->where('order_status', '=', 'Waiting acceptance')
        ->where('order_type', '=', 'Pre Order')
        ->where(function ($query) use ($searchTerm) {
            $query->whereHas('Customer', function ($subQuery) use ($searchTerm) {
                $subQuery->where('customer_name', 'like', $searchTerm);
            })
                ->orWhereHas('User', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('name', 'like', $searchTerm);
                });
        })
        ->when($this->fromDate, function ($query) {
            $query->whereDate('created_at', '>=', $this->fromDate);
        })
        ->when($this->toDate, function ($query) {
            $query->whereDate('created_at', '<=', $this->toDate);
        })
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.orders.pendingdeliveries', compact('orders'));
    }
    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }

    public function details($code)
    {
        $order = Orders::with('orderItems.Information')->where('order_code', $code)->first();

        if (!isset($order->orderItems)) {
            return 0;
        }

        $orderItems = $order->orderItems;
        $total = 0;
        foreach ($orderItems as $item) {
            $numericSku = intval(preg_replace('/[^0-9]/', '', $item->Information->sku_code));
            $total += $numericSku;
        }
        return $total;
    }

    public function deactivate($id)
    {

        Orders::whereId($id)->update([
            'order_status' => 'CANCELLED',
        ]);
        $this->render();
    }
    public function activate($id)
    {
        Orders::whereId($id)->update([
            'order_status' => 'Pending Delivery',
        ]);
        $this->render();
    }
}
