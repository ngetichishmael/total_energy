<?php

namespace App\Http\Livewire\Customers;

use App\Exports\customers as ExportsCustomers;
use App\Models\customer\customers;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public ?string $search = null;
   public function render()
   {
      $searchTerm = '%' . $this->search . '%';
      $contacts = customers::with('Area.Subregion.Region')->whereLike(
         [
            'Area.name',
            'customer_name',
            'phone_number',
            'address',
         ],
         $searchTerm
      )
         ->paginate($this->perPage);
      return view('livewire.customers.dashboard', [
         'contacts' => $contacts
      ]);
   }
   public function export()
   {
      return Excel::download(new ExportsCustomers, 'customers.xlsx');
   }
}
