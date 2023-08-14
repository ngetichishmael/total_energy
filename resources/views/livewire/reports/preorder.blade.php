<div>
    <div class="card">
        <h5 class="card-header"></h5>
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
            <div class="col-md-3 user_role">
                <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                    <input wire:model.debounce.300ms="search" type="text" id="fname-icon" class="form-control"
                        name="fname-icon" placeholder="Search" />
                </div>
            </div>
            <div class="col-md-2 user_role">
                <div class="form-group">
                    <label for="selectRegion">Region</label>
                    <select wire:model="subregionFilter" class="form-control form-control-sm" id="selectSubregion">
                        <option value="">All Subregions</option>
                    
                    </select>
                </div>
            </div>

            <div class="col-md-2 user_role">
                <div class="form-group">
                    <label for="selectArea">Area</label>
                    <select wire:model="areaFilter" class="form-control form-control-sm" id="selectArea">
                        <option value="">All Areas</option>
                 
                    </select>
                </div>
            </div>


            <div class="col-md-2 d-flex justify-content-end">
                <div class="demo-inline-spacing">
                    <a href="{!! route('customer.create') !!}" class="btn btn-outline-secondary">Add Customer</a>

                </div>
            </div>
        </div>
    </div>

    <div class="pt-0 pb-2 d-flex justify-content-end align-items-center mx-90 row">
        <div class="col-md">
            <div class="btn-group">
                <button type="button" class="btn btn-icon btn-outline-primary dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" wire:loading.attr="disabled">
                    <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="15" height="15">
                    Export
                </button>
                <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" wire:click="export" id="exportExcelBtn">Excel</a>
                    <a class="dropdown-item" wire:click="exportCSV" id="exportPdfBtn"> CSV</a>
                    <a class="dropdown-item" wire:click="exportPDF" id="exportCsvBtn">PDF</a>
                    <!-- <a class="dropdown-item" wire:click="printAndRedirect" id="printBtn">Print</a> -->

                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="validationTooltip01">Start Date</label>
                <input wire:model="start" name="startDate" type="date" class="form-control" id="validationTooltip01"
                    placeholder="YYYY-MM-DD HH:MM" required />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="validationTooltip01">End Date</label>
                <input wire:model="end" name="startDate" type="date" class="form-control" id="validationTooltip01"
                    placeholder="YYYY-MM-DD HH:MM" required />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="">Perpage: </label>
                <select wire:model="perPage" class="form-control">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>


    <!-- <div class="col-md-3">
        <label for="validationTooltip01">Start Date</label>
        <input wire:model="start" name="startDate" type="date" class="form-control" id="validationTooltip01"
            placeholder="YYYY-MM-DD HH:MM" required />
    </div>
    <div class="col-md-3">
        <label for="validationTooltip01">End Date</label>
        <input wire:model="end" name="endDate" type="date" class="form-control" id="validationTooltip01"
            placeholder="YYYY-MM-DD HH:MM" required />
    </div>
    <div class="col-md-3">
        <label for="">User Category</label>
        <select wire:model="userCategory" class="form-control">
            <option value="" selected>select</option>
            <option value=""></option>
        </select>
    </div>
    <div class="col-md-3">
        <button type="button" class="btn btn-icon btn-outline-success" wire:click="export" wire:loading.attr="disabled"
            data-toggle="tooltip" data-placement="top" title="Export Excel">
            <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="20" height="20"
                data-toggle="tooltip" data-placement="top" title="Export Excel">Export to Excel
        </button>
    </div> -->
<!-- </div>
<br>
<div class="row">
    <div class="col-md-3">
        <label for="">Status</label>
        <select wire:model="status" class="form-control">
            <option value="" selected>select</option>
            <option value=""></option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="">Search by name, route, region</label>
        <input type="text" wire:model="search" class="form-control"
            placeholder="Enter customer name, email address or phone number">
    </div>
</div>
<br>
<br> -->


@include('partials.stickymenu')
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
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Added by</th>
                                <th>Region</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($preorders as $preorder)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $preorder->order_code }}</td>
                                    <td>{{ $preorder->Customer->customer_name ?? '' }}</td>
                                    <td>{{ $preorder->User->name ?? '' }}</td>
                                    <td class="cell-fit">
                                        {{ $preorder->Customer->Area->Subregion->name ?? '' }},
                                        {{ $preorder->User->Region->name ?? '' }}
                                    </td>
                                    <td>{{ $preorder->order_status ?? '' }}</td>
                                    <td>{{ $preorder->created_at->format('d/m/Y') ?? '' }}</td>
                                    <td><a href="{{ URL('orders/items/' . $preorder->order_code) }}" class="btn btn-sm"
                                            style="background-color: rgb(173, 37, 37);color:white">View</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <x-emptyrow>
                                        7
                                    </x-emptyrow>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-1">{!! $preorders->links() !!}</div>
            </div>
        </div>
    </div>
</div>
