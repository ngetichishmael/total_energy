<?php

namespace App\Http\Livewire\Survery;

use App\Models\survey\survey;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 5;
   public $search;
    public function render()
    {

      $surveries = survey::orderby('id', 'desc')->paginate($this->perPage);
        return view('livewire.survery.dashboard',[
         'surveries'=> $surveries
        ]);
    }
}
