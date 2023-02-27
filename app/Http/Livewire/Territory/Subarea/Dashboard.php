<?php

namespace App\Http\Livewire\Territory\Subarea;

use App\Models\Subarea;
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
      $subareas = Subarea::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);
      return view('livewire.territory.subarea.dashboard', [
         'subareas' => $subareas
      ]);
   }
}
