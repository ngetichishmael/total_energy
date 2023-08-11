<?php

namespace App\Http\Livewire\Customer;

use App\Models\Orders;
use App\Models\order_payments;
use Livewire\Component;

class Payment extends Component
{
    public $customer_id;
    public function render()
    {
        return view('livewire.customer.payment', [
            'payments' => $this->data(),
        ]);
    }

    public function data()
    {
        $array = [];
        $orders = Orders::where('customerID', $this->customer_id)->pluck('order_code');
        if ($orders->isEmpty()) {
            return $array;
        }
        return order_payments::whereIn('order_id', $orders)->get();

    }
    public function pluckLastPart($string)
    {
        $prefix = "PaymentMethods.";
        if (strpos($string, $prefix) === 0) {
            return substr($string, strlen($prefix));
        } else {
            return $string;
        }
    }

}
