<div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>User Type</th>
                <th>Visits</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach ($visits as $key => $visit)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $visit->name ?? '' }}</td>
                    <td>{{ $visit->account_type }}</td>
                    <td>{{ $visit->checkings_count }}</td>
               
                </tr>
            @endforeach

        </tbody>
</table>

    <div class="mt-4">
        <button wire:click="export" class="btn btn-primary">Export CSV</button>
    </div>
</div>