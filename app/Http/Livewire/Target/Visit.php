<?php

namespace App\Http\Livewire\Target;

use App\Models\VisitsTarget;
use Carbon\Carbon;
use Livewire\Component;

class Visit extends Component
{
    public function render()
    {

      $today = Carbon::now();
         $visits=VisitsTarget::all();
        return view('livewire.target.visit',[
         'visits'=>$visits,
         'today'=>$today
        ]);
    }
}
