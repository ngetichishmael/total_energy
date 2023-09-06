<div>
    <div class="row">
        <div class="col-md-3">
            <label for="status">Status</label>
            <select wire:model="status" class="form-control">
                <option value="" selected>All</option>
                @foreach ($allocation_status as $status)
                    <option value="{{ $status->status }}">{{ $status->status }}</option>
                @endforeach

            </select>
        </div>
        <div class="col-md-3">
            <label for="search">Search by name, route, region</label>
            <input type="text" wire:model="search" class="form-control"
                placeholder="Enter customer name, email address or phone number">
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-inverse">
                <div class="card-body">
                    <div class="d-flex flex-row flex-nowrap overflow-auto">
                        <table id="data-table-default" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sales Agent</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Region</th>
                                    <th>Source</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lifted as $key => $liftedItem)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $liftedItem->user_name }}</td>
                                        <td>{{ $liftedItem->qty ?? '' }}</td>
                                        <td>{{ $liftedItem->status ?? '' }}</td>
                                        <td>{{ $liftedItem->user_region ?? '' }}</td>
                                        <td>{{ $liftedItem->warehouse }}</td>
                                        <td>{{ $liftedItem->date }}</td>
                                        <td><a href="{{ URL('lifted/items/' . $liftedItem->code) }}" class="btn btn-sm"
                                                style="color:white;background-color:rgb(202, 50, 50)">View</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-1">{!! $lifted->links() !!}</div>
                </div>
            </div>
        </div>
    </div>
</div>
