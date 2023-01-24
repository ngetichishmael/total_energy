<?php

namespace App\Http\Livewire\Territory\Zone;

use App\Models\zone;
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
      $zones = zone::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);
      return view('livewire.territory.zone.dashboard', [
         'zones' => $zones
      ]);
   }
}