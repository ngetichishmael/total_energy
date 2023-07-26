<div>
    <div class="mb-1 row">
        <div class="col-md-10">
            <label for="">Search</label>
            <input type="text" wire:model="search" class="form-control"
                placeholder="Search by User, Customer Name or Region">
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
                        <th>Zone</th>
                        <th>User</th>
                        <th>Customer</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </thead>
                    <tbody>
                        @foreach ($visits as $count => $visit)
                            <td>{!! $count + 1 !!}</td>
                            <td>{!! $visit->User->Region->name !!}</td>
                            <td>{!! $visit->User->name !!} </td>
                            <td> {{ $visit->Customer->customer_name }}</td>
                            <td>{{ $visit->start_time }}</td>
                            <td>{{ $visit->stop_time ?? 'User within' }}</td>

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
