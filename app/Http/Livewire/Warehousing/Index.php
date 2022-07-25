<?php

namespace App\Http\Livewire\Warehousing;

use Livewire\Component;
use App\Models\warehousing;
use Livewire\WithPagination;
use Auth;
class Index extends Component
{
   use WithPagination;
   public $perPage = 40;
   public $search = '';
   public $orderBy = 'id';
   public $orderAsc = true;

   public function updatingSearch()
   {
      $this->resetPage();
   }

   public function render()
   {
      $warehouses = warehousing::where('business_code', Auth::user()->business_code)
                              ->orderBy($this->orderBy,$this->orderAsc ? 'asc' : 'desc')
                              ->simplePaginate($this->perPage);

      return view('livewire.warehousing.index', compact('warehouses'));
   }
}


