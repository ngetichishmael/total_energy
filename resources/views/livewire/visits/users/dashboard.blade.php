<div>
    <div class="mb-1 row">
        <div class="col-md-10">
            <label for="">Search</label>
            <input type="text" wire:model="search" class="form-control" placeholder="Search by User or Region">
        </div>
        <div class="col-md-2">
            <label for="">Items Per</label>
            <select wire:model="perPage" class="form-control">`
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th width="1%">#</th>
                        <th>User</th>
                        <th>Zone</th>
                        <th>Total Visits</th>
                        <th>Schedule By User</th>
                        <th>Scheduled By Admin</th>
                        <th>Imprompt</th>
                    </thead>
                    <tbody>
                        @foreach ($visits as $count => $visit)
                            <td>{!! $count + 1 !!}</td>
                            <td>
                                {!! $visit->User->name !!}
                            </td>
                            <td>{!! $visit->User->Region->name !!}</td>
                            <td> {{ $visit->customer_count }}</td>
                            <td>{{ $visit->self_count }}</td>
                            <td>{{ $visit->admin_count }}</td>
                            <td>{{ $visit->imprompt_count }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-1">
                    {{ $visits->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
