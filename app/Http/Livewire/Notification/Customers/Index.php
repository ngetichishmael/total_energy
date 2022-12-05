<?php

namespace App\Http\Livewire\Notification\Customers;

use App\Models\customers;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public ?string $search = null;
   public $perPage = 10;
   public $sortField = 'id';
   public $sortAsc = true;
   public bool $bulkDisabled = true;
   public $selectedData = [];
    public function render()
    {

      $this->bulkDisabled = count($this->selectedData) < 1;

      $searchTerm = '%' . $this->search . '%';
      $customers=customers::whereLike(
         [
             'customer_name',
             'address',
         ],
         $searchTerm
     )
     ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
     ->paginate($this->perPage);
        return view('livewire.notification.customers.index',[
         'users'=>$customers,
        ]);
    }
}
