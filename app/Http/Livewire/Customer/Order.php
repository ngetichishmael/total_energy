<?php

namespace App\Http\Livewire\Customer;

use App\Models\Orders;
use Livewire\Component;

class Order extends Component
{
    public $customer_id;
    public function render()
    {
        return view('livewire.customer.order', [
            'orders' => Orders::with('User')->where('customerID', $this->customer_id)->get(),
        ]);
    }
}
