<div>
    <div class="card">
        <h5 class="card-header"></h5>
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
            <div class="col-md-4 user_role">
                <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                    <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon"
                        placeholder="Search" />
                </div>
            </div>
            <div class="col-md-2 user_role">
                <div class="form-group">
                    <label for="selectSmall">Per Page</label>
                    <select wire:model="perPage" class="form-control form-control-sm" id="selectSmall">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 d-flex justify-content-end">
                <div class="demo-inline-spacing">
                    <a href="{!! route('warehousing.create') !!}" class="btn btn-outline-secondary">Add Warehouse</a>

                    <div class="btn-group">

                    <button type="button" class="btn btn-icon btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" wire:loading.attr="disabled" >
                        <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="15" height="15">
                        Export
                    </button>
                    <div class="dropdown-menu">
                            <a class="dropdown-item" wire:click="export" id="exportExcelBtn">Excel</a>
                            <a class="dropdown-item"  wire:click="exportCSV" id="exportPdfBtn"> CSV</a>
                            <a class="dropdown-item" wire:click="exportPDF" id="exportCsvBtn">PDF</a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-body">
            <table class="table table-striped table-bordered" style="font-size: small">
                <thead>
                    <tr>
                        <th width="1%">#</th>
                        <th>Name</th>
                        <th>Region</th>
                        <th>Sub Region</th>
                        <th>Products Count</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($warehouses as $count => $warehouse)
                    <tr>
                        <td>{{ $count + 1 }}</td>
                        <td>{{ $warehouse->name ?? '' }}</td>
                        <td>{{ $warehouse->region->name ?? '' }}</td>
                        <td>{{ $warehouse->subregion->name ?? '' }}</td>
                        <td>{{ $warehouse->product_information_count ?? 0 }}</td>
                        <td>
                            @if ($warehouse->status === 'Active')
                                    <span class="badge badge-pill badge-light-success mr-1">Active</span>
                                @else
                                    <span class="badge badge-pill badge-light-warning mr-1">Disabled</span>
                                @endif
                            </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle show-arrow "
                                    data-toggle="dropdown" style="background-color: #0186f5; color:white">
                                    <i data-feather="settings"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{ route('warehousing.show', ['warehouse_code' => $warehouse->warehouse_code]) }}">
                                        <i data-feather="eye" class="mr-50"></i>
                                        <span>View</span>
                                    </a>
{{--                                    <a class="dropdown-item"--}}
{{--                                        href="{{ route('warehousing.edit', $warehouse->warehouse_code) }}">--}}
{{--                                        <i data-feather="edit" class="mr-50"></i>--}}
{{--                                        <span>Edit</span>--}}
{{--                                    </a>--}}
                                    <a class="dropdown-item"
                                        href="{{ route('warehousing.products', $warehouse->warehouse_code) }}">
                                        <i data-feather="arrow-right-circle" class="mr-50"></i>
                                        <span>Inventory</span>
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{ route('warehousing.assign', ['warehouse_code' => $warehouse->warehouse_code]) }}">
                                        <i data-feather="user-check" class="mr-50"></i>
                                        <span>Assign Manager</span>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">No warehouses found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {!! $warehouses->links() !!}
        </div>
    </div>
</div>
