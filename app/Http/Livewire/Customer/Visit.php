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
            'checkins' => checkin::with('user')
            ->where('customer_id', $this->customer_id)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get(),
                ]);
    }
}
