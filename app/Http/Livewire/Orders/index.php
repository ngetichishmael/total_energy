<?php

namespace App\Http\Livewire\Orders;

use App\Exports\OrdersExport;
use App\Models\AssignedRegion;
use App\Models\customer\customers;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 5;
    public $search = null;
    public $orderBy = 'orders.id';
    public $orderAsc = false;
    public $customer_name = null;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }
    public function render()
    {

        return view('livewire.orders.index', [
            'orders' => $this->orders(),
        ]);
    }
    public function orders()
    {

        $searchTerm = '%' . $this->search . '%';
        $perpage = $this->search == null ? $this->perPage : 1000;
        $orders = Orders::with('Customer', 'user', 'OrderItems')
            ->search($searchTerm)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($perpage);
        return $orders;
    }
    public function areas()
    {
        $array = [];
        $user_code = $this->user->user_code;

        $regions = AssignedRegion::where('user_code', $user_code)->pluck('region_id');
        if ($regions->isEmpty()) {
            return $array;
        }
        $customers = customers::whereIn('region_id', $regions->toArray())->pluck('id');
        return $customers->toArray();

    }
    public function shipment()
    {

        return redirect()->route('picking-sheet')->with([
            "products" => $this->orders(),
        ]);
    }
    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
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
