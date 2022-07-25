<?php

namespace App\Http\Livewire\Delivery;
use App\Models\Delivery;
use Livewire\Component;
use Auth;
use Livewire\WithPagination;

class index extends Component
{
   use WithPagination;
   public $perPage = 10;
   public $search = '';
   public $orderBy = 'delivery.id';
   public $orderAsc = true;

   public function render()
   {
      $deliveries = Delivery::join('customers','customers.id','=','delivery.customer')
                           ->join('users','users.user_code','=','delivery.allocated')
                           ->where('delivery.business_code',Auth::user()->business_code)
                           ->select('customer_name','name','delivery.created_at as delivery_date','delivery_status','order_code')
                           ->orderBy($this->orderBy,$this->orderAsc ? 'desc' : 'asc')
                           ->simplePaginate($this->perPage);

      return view('livewire.delivery.index', compact('deliveries'));
   }
}
