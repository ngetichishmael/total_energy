<div>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Added By</th>
                <th>Region</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_code }}</td>
                    <td>{{ $order->Customer->customer_name ?? '' }}</td>
                    <td>{{ $order->User->name ?? '' }}</td>
                    <td class="cell-fit">
                        {{ $order->Customer->Area->Subregion->name ?? '' }},
                        {{ $order->User->Region->name ?? '' }}
                    </td>
                    <td>{{ $order->order_status ?? '' }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <button wire:click="export" class="btn btn-primary">Export CSV</button>
    </div>
</div>