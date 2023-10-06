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
            'orders' => Orders::with('User')
            ->where('customerID', $this->customer_id)
            ->orderBy('created_at', 'desc') // Order by created_at in descending order
            ->take(14) // Limit the result to 14 records
            ->get(),
                ]);
    }
}
