<?php

namespace App\Http\Livewire\Territory\SubRegion;

use App\Models\Subregion;
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
      $subregions = Subregion::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);
      return view('livewire.territory.sub-region.dashboard', [
         'subregions' => $subregions
      ]);
   }
}