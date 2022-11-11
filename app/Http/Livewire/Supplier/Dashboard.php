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
      $suppliers = suppliers::join('business','business.business_code','=','suppliers.business_code')
							->where('suppliers.business_code',Auth()->user()->business_code)
                     ->select('*','suppliers.id as supplierID','suppliers.name as supplier_name','suppliers.email as supplier_email','suppliers.phone_number as phone_number','suppliers.created_at as created_at')
							->OrderBy('suppliers.id','DESC')
							->paginate(7);
		$count = 1;
        return view('livewire.supplier.dashboard',compact('suppliers','count'));
    }
}
