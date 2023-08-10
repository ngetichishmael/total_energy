<div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $paymentMethod == 'PaymentMethods.Mpesa' ? 'active' : '' }}"
                wire:click="$set('paymentMethod', 'PaymentMethods.Mpesa')">Mpesa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $paymentMethod == 'PaymentMethods.Cheque' ? 'active' : '' }}"
                wire:click="$set('paymentMethod', 'PaymentMethods.Cheque')">Cheque</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $paymentMethod == 'PaymentMethods.Cash' ? 'active' : '' }}"
                wire:click="$set('paymentMethod', 'PaymentMethods.Cash')">Cash</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $paymentMethod == 'PaymentMethods.BankTransfer' ? 'active' : '' }}"
                wire:click="$set('paymentMethod', 'PaymentMethods.BankTransfer')">Bank to Bank</a>
        </li>
    </ul>
    <div class="tab-content mt-3">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order Code</th>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Sales Agent</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $count=>$payment)
                    <tr>
                        <td>{!! $count + 1 !!}</td>
                        <td>{!! $payment->order_id !!}</td>
                        <td>{!! $payment->reference_number ?? '' !!}</td>
                        <td>{!! $payment->payment_date !!}</td>
                        <td>{!! $payment->customer_name ?? '' !!}</td>
                        <td>{!! $payment->name !!}</td>
                        <td>{!! number_format($payment->amount, 2) !!}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No Payments found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
