<?php

namespace App\Http\Livewire\Productapproval;

use App\Models\warehousing;
use Livewire\Component;
use Livewire\WithPagination;

class Requisitionapprovalwarehouses extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $orderBy = 'id';
    public $search = "";
    public $orderAsc = true;
    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $warehouses = warehousing::withCount([
            'stockRequisitions as approval_count' => function ($query) {
                $query->where('status', 'Waiting Approval');
            },
        ])
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', $searchTerm);
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->paginate($this->perPage);
        return view('livewire.productapproval.requisitionapprovalwarehouses', compact('warehouses'));
    }
}
