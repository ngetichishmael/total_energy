<?php

namespace App\Http\Livewire\Target;

use App\Models\LeadsTargets;
use Carbon\Carbon;
use Livewire\Component;

class Lead extends Component
{
    public function render()
    {
      $today = Carbon::now();
      $leads=LeadsTargets::all();
        return view('livewire.target.lead',[
         'leads' => $leads,
         'today' =>$today
        ]);
    }
}
