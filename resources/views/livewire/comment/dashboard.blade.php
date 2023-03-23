<div>
    <div class="mb-1 row">
        <div class="col-md-10">
            <label for="">Search</label>
            <input type="text" wire:model="search" class="form-control"
                placeholder="Enter customer name, Sales Agents, Date">
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
            <table class="table table-striped table-bordered">
                <thead>
                    <th width="1%">#</th>
                    <th>Customer Name</th>
                    <th>Sales Agent</th>
                    <th>Date</th>
                    <th>Comment</th>
                </thead>
                <tbody>
                    @foreach ($comments as $count => $comment)
                        <td>{{ $count + 1 }}</td>
                        <td>{{ $comment->Customer->customer_name }}</td>
                        <td>{{ $comment->User->name }}</td>
                        <td>{{ $comment->date }}</td>
                        <td>{{ $comment->comment }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-1">
                {{ $comments->links() }}
            </div>

        </div>
    </div>
</div>
