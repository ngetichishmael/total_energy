<?php

namespace App\Http\Livewire\Orders;

use App\Exports\OrdersExport;
use Livewire\Component;
use App\Models\Orders;
use Livewire\WithPagination;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 5;
   public $search;
   public $orderBy = 'orders.id';
   public $orderAsc = false;
   public $customer_name = null;

   public function updatingSearch()
   {
      $this->resetPage();
   }
   public function render()
   {
      $orders =  Orders::join('customers', 'customers.id', '=', 'orders.customerID')
         ->join('users', 'users.user_code', '=', 'orders.user_code')
         ->when($this->customer_name, function ($query) {
            $query->where('customer_name', $this->customer_name);
         })
         ->search(trim($this->search))
         ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);

      return view('livewire.orders.index', compact('orders'));
   }
   public function export()
   {
       return Excel::download(new OrdersExport, 'orders.xlsx');
   }

   // public function render()
   // {
   //    return view('livewire.orders.index',[
   //       'orders' => Orders::whereLike('model', $this->search??''),

   //    ]);
   // }
}
