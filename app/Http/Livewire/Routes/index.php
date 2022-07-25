<?php

namespace App\Http\Livewire\Routes;

use Livewire\Component;
use App\Models\customer\customers;
use Livewire\WithPagination;
use App\Models\Routes;
use Auth;
class Index extends Component
{
   use WithPagination;
   public $perPage = 10;
   public $search = '';
   public function render()
   {
      $routes = Routes::simplePaginate($this->perPage);

      return view('livewire.routes.index', compact('routes'));
   }
}
