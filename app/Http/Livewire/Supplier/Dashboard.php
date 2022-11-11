<?php

namespace App\Http\Livewire\Supplier;

use App\Models\suppliers\suppliers;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{

   use WithPagination;
 protected $paginationTheme = 'bootstrap';
    public function render()
    {
      $suppliers = suppliers::where('suppliers.business_code',Auth()->user()->business_code)
							->OrderBy('suppliers.id','DESC')
							->paginate(7);
        return view('livewire.supplier.dashboard',compact('suppliers'));
    }
}
