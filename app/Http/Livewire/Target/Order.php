<?php

namespace App\Http\Livewire\Target;

use App\Models\OrdersTarget;
use Carbon\Carbon;
use Livewire\Component;

class Order extends Component
{
    public function render()
    {
      $today = Carbon::now();
      $orders=OrdersTarget::all();
        return view('livewire.target.order',[
         'orders' => $orders,
         'today' =>$today
        ]);
    }
}
