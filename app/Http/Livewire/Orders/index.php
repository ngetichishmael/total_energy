<?php

namespace App\Http\Livewire\Orders;

use Livewire\Component;
use App\Models\Orders;
use Livewire\WithPagination;
use Auth;
class Index extends Component
{
   use WithPagination;
   public $perPage = 40;
   public $search = '';
   public $orderBy = 'orders.id';
   public $orderAsc = false;

   public function updatingSearch()
   {
      $this->resetPage();
   }

   public function render()
   {
      $orders =  Orders::join('customers','customers.id','=','orders.customerID')
                        ->join('users','users.user_code','=','orders.user_code')
                        ->orderBy($this->orderBy,$this->orderAsc ? 'asc' : 'desc')
                        ->simplePaginate($this->perPage);

      return view('livewire.orders.index', compact('orders'));
   }
}


