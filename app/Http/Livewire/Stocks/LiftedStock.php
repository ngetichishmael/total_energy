<?php

namespace App\Http\Livewire\Stocks;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class LiftedStock extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $status = '';
    public $allocation_status = [];
    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $status = '%' . $this->status . '%';
        $lifted = DB::table('inventory_allocations')
            ->join('inventory_allocated_items', 'inventory_allocations.allocation_code', '=', 'inventory_allocated_items.allocation_code')
            ->join('product_information', 'inventory_allocated_items.product_code', '=', 'product_information.id')
            ->join('warehouse', 'product_information.warehouse_code', '=', 'warehouse.warehouse_code')
            ->join('users', 'inventory_allocations.sales_person', '=', 'users.user_code')
            ->join('regions', 'users.route_code', '=', 'regions.id')
            ->select('inventory_allocations.allocation_code as code',
                'product_information.product_name as name',
                'inventory_allocated_items.current_qty as qty',
                'inventory_allocations.updated_at as date',
                'warehouse.name as warehouse',
                'inventory_allocations.status as status',
                'users.name as user_name',
                'regions.name as user_region')
            ->when(
                $searchTerm, function ($query) use ($searchTerm) {
                    $query->where('users.name', 'LIKE', $searchTerm);
                }
            )
            ->when(
                $status, function ($query) use ($status) {
                    $query->where('inventory_allocations.status', 'LIKE', $status);
                }
            )
            ->orderBy('inventory_allocations.updated_at', 'desc')->paginate(10);

        return view('livewire.stocks.lifted-stock', [
            'lifted' => $lifted,
            $this->allocation_status = DB::table('inventory_allocations')->select(
                DB::raw('DISTINCT status as status')
            )->get(),
        ]);

    }
    public function mount()
    {
        $this->allocation_status = DB::table('inventory_allocations')->select(
            DB::raw('DISTINCT status as status')
        )->get();
    }
}
