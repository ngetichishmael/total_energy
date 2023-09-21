<div>
    <table id="data-table-default" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>User Type</th>
                <th>Number of Users</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usercount as $key => $user)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $user->account_type }}</td>
                    <td>{{ $user->count }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <div class="mt-4">
        <button wire:click="export" class="btn btn-primary">Export CSV</button>
    </div>
</div>