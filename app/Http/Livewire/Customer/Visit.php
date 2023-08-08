<?php

namespace App\Http\Livewire\Customer;

use App\Models\customer\checkin;
use Livewire\Component;

class Visit extends Component
{
    public $customer_id;
    public function render()
    {
        return view('livewire.customer.visit', [
            'checkins' => checkin::with('user')->whereIn('id', [1, 2, 3])->limit(3)->get(),
        ]);
    }
}
