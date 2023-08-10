<?php

namespace App\Http\Livewire\Payment\Paid;

use App\Models\order_payments;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $paymentMethod = 'PaymentMethods.Mpesa';

    public function render()
    {
        $payments = order_payments::join('orders', 'orders.order_code', '=', 'order_payments.order_id')
            ->join('customers', 'customers.id', '=', 'orders.customerID')
            ->join('users', 'customers.created_by', '=', 'users.id')
            ->where('payment_method', $this->paymentMethod)
            ->select(
                'order_payments.order_id as order_id',
                'order_payments.reference_number as reference_number',
                'order_payments.payment_date as payment_date',
                'order_payments.amount as amount',
                'users.name as name',
                'customers.customer_name as customer_name',
            )
            ->get();

        return view('livewire.payment.paid.dashboard', [
            'payments' => $payments,
        ]);
    }

//     PaymentMethods.Mpesa
// PaymentMethods.Cash
// PaymentMethods.BankTransfer
// PaymentMethods.Cheque
}
