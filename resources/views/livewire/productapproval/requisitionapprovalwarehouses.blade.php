<div>
    <div class="row mb-1">
        <div class="col-md-10">
            <label for="">Search</label>
            <input type="text" wire:model="search" class="form-control" placeholder="Enter name">
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
            <table class="table table-striped table-bordered table-responsive" style="font-size: small">
                <thead>
                    <th width="1%">#</th>
                    <th>Name</th>
                    <th>Region</th>
                    <th>Requisitions Counts</th>
                    <th>Action | View</th>
                </thead>
                <tbody>
                    @foreach ($warehouses as $count => $warehouse)
                        <tr>
                            <td>{!! $count + 1 !!}</td>
                            <td>{!! $warehouse->name !!}</td>
                            <td>{!! $warehouse->region->name ?? '' !!}</td>
                            <td>{!! $warehouse->approval_count ?? 0 !!}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"
                                        style="background-color:#1877F2 !important; color:#ffffff;">
                                        <i data-feather='settings'></i>
                                    </button>
                                    <div class="dropdown-menu g-25" aria-labelledby="dropdownMenuButton" style="gap:20">
                                        <a class="dropdown-item btn btn-flat-primary btn-sm"
                                            href="{{ route('inventory.approval', $warehouse->warehouse_code) }}">Waiting
                                            Approvals</a>
                                        <a class="dropdown-item btn btn-flat-primary btn-sm"
                                            href="{{ route('inventory.approved', $warehouse->warehouse_code) }}">Approved</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $warehouses->links() !!}
        </div>
    </div>
</div>
@section('scripts')
@endsection
