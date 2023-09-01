<?php

namespace App\Http\Livewire\Stocks;

use App\Models\warehousing;
use Livewire\Component;
use Livewire\WithPagination;

class Reconciliation extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $orderBy = 'id';
    public $orderAsc = true;
    public ?string $search = null;
    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $warehouses = warehousing::with('region', 'subregion', 'ReconciledProducts')
            ->when($searchTerm,
                function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', $searchTerm);
                }
            )
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.stocks.reconciliation', ['warehouses' => $warehouses]);
    }
}
