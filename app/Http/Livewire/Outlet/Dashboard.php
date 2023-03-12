<?php

namespace App\Http\Livewire\Outlet;

use App\Models\OutletType;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 40;
   public $sortField = 'id';
   public $sortAsc = true;
   public function render()
   {
      $outlets = OutletType::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);
      return view('livewire.outlet.dashboard', [
         'outlets' => $outlets
      ]);
   }
}
