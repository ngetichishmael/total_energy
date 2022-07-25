<?php

namespace App\Http\Livewire\Inventory;

use App\Models\inventory\allocations;
use Livewire\Component;
use App\Models\User;
use Auth;
class Allocated extends Component
{
   public function render()
   {
      $salesPerson = User::where('business_code',Auth::user()->business_code)->pluck('name','user_code')->prepend('choose','');
      $allocations = allocations::join('users','users.user_code','=','inventory_allocations.sales_person')
                              ->where('inventory_allocations.business_code',Auth::user()->business_code)
                              ->select('*','inventory_allocations.created_at as created_at','inventory_allocations.status as status')
                              ->get();

      return view('livewire.inventory.allocated', compact('salesPerson','allocations'));
   }
}
