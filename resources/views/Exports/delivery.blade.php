<div>
    <table id="data-table-default" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>User Name</th>
                <th>User Type</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($deliveries as $delivery)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $delivery->order_code }}</td>
                    <td>{{ $delivery->order_status }}</td>
                    <td>{{ optional($delivery->Customer)->customer_name }}</td>
                    <td>{{ optional($delivery->User)->name }}</td>
                    <td>{{ optional($delivery->User)->account_type }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <button wire:click="export" class="btn btn-primary">Export CSV</button>
    </div>
</div>