<div>
    <table class="table table-striped table-bordered table-responsive">
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>User Type</th>
                <th>Target</th>
                <th>Achieved</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($targets as $key => $target)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $target->name }}</td>
                    <td>{{ $target->account_type }}</td>
                    <td class="cell-fit">
                        <strong>Leads:</strong> {{ $target->leads_target }},<strong>Orders:</strong>
                        {{ $target->orders_target }},<strong>Sales:</strong>
                        {{ $target->sales_target }},<strong>Visits:</strong>
                        {{ $target->visits_target }}
                    </td>
                    <td class="cell-fit">
                        <strong>Leads:</strong>
                        {{ $target->achieved_leads_target }},<strong>Orders:</strong>
                        {{ $target->achieved_orders_target }},<strong>Sales:</strong>
                        {{ $target->achieved_sales_target }},<strong>Visits:</strong>
                        {{ $target->achieved_visits_target }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <button wire:click="export" class="btn btn-primary">Export CSV</button>
    </div>
</div>