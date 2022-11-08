<?php

namespace App\Http\Livewire\Customers;

use App\Exports\customers as ExportsCustomers;
use App\Models\customer\customers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public $search;
   public function render()
   {
      $contacts = customers::join('business', 'business.business_code', '=', 'customers.business_code')
         ->where(
            'customers.business_code',
            Auth::user()->business_code
         )
         ->whereNotNull('customers.email')
         ->select(
            '*',
            'customers.id as customerID',
            'customers.created_at as date_added',
            'business.business_code as business_code',
            'customers.business_code as business_code',
            'customers.email as customer_email',
            'customers.phone_number as phone_number'
         )
         ->paginate($this->perPage);
      $count = 1;
      return view('livewire.customers.dashboard', [
         'contacts' => $contacts,
         'count' => $count,
      ]);
   }
   public function export()
   {
      return Excel::download(new ExportsCustomers, 'customers.xlsx');
   }
}
