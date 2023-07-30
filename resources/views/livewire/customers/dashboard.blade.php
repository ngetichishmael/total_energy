<div>
<div class="card">
        <h5 class="card-header"></h5>
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
            <div class="col-md-3 user_role">
                <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                    <input wire:model.debounce.300ms="search" type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
                </div>
            </div>
            <div class="col-md-2 user_role">
                <div class="form-group">
                    <label for="selectRegion">Region</label>
                    <select wire:model="subregionFilter" class="form-control form-control-sm" id="selectSubregion">
                <option value="">All Subregions</option>
                @foreach ($subregions as $subregion)
                    <option value="{{ $subregion->id }}">{{ $subregion->name }}</option>
                @endforeach
            </select>
                </div>
            </div>

            <div class="col-md-2 user_role">
            <div class="form-group">
                <label for="selectArea">Area</label>
                <select wire:model="areaFilter" class="form-control form-control-sm" id="selectArea">
                    <option value="">All Areas</option>
                    @if ($subregionFilter)
                        @foreach ($areasInSubregion as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    @endif
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
    <button type="button" class="btn btn-icon btn-outline-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" wire:loading.attr="disabled" >
                        <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="15" height="15">
                        Export
                    </button>
                        <div class="dropdown-menu dropdown-menu-left">
                            <a class="dropdown-item" wire:click="export" id="exportExcelBtn">Excel</a>
                            <a class="dropdown-item"  wire:click="exportCSV" id="exportPdfBtn"> CSV</a>
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
     <div class="card card-default">
        <div class="card-body">
            <div class="pt-0 card-datatable">
            <table class="table table-striped table-bordered zero-configuration table-responsive">
                <thead>
                    <th width="15%">Name</th>
                    <th>Number</th>
                    <th width="15%">Address</th>
                    <th width="15%">Zone/Region</th>
                    <th width="15%">Route</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @forelse ($contacts as $count => $contact)
                        <!-- <td>{!! $count + 1 !!}</td> -->
                        <tr>
                            <td>
                                {!! $contact->customer_name !!} <br>
                                @if ($contact->approval === 'Approved')
                                    <span class="badge badge-pill badge-light-success mr-1">Approved</span>
                                @else
                                    <span class="badge badge-pill badge-light-warning mr-1">Pending</span>
                                @endif
                            </td>
                            <td>{!! $contact->phone_number !!}</td>
                            <td>
                                {{ $contact->address }}
                            </td>
                            <td>
                                @if ($contact->Area && $contact->Area->Subregion && $contact->Area->Subregion->Region)
                                    {!! $contact->Area->Subregion->Region->name !!}
                                    @if ($contact->Area->Subregion->name)
                                        , <br><i>{!! $contact->Area->Subregion->name !!}</i>
                                    @endif
                                @endif
                            </td>
                            <td>
                                {!! $contact->Area->name ?? '' !!}
                            </td>
                            <td>
                                {!! $contact->Creator->name ?? '' !!}
                            </td>
                            <td>
                                {!! $contact->created_at ? $contact->created_at->format('Y-m-d h:i A') : '' !!}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle show-arrow " data-toggle="dropdown" style="background-color: #089000; color:white" >
                                        <i data-feather="eye"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('make.orders', ['id' => $contact->id]) }}">
                                            <i data-feather="eye" class="mr-50"></i>
                                            <span>Order</span>
                                        </a>
                                        <a class="dropdown-item" href="{{ route('customer.edit', $contact->id) }}">
                                            <i data-feather='edit' class="mr-50"></i>
                                            <span>Edit</span>
                                        </a>
                                        @if ($contact->approval === 'Approved')
                                            <a wire:click.prevent="deactivate({{ $contact->id }})"
                                                onclick="confirm('Are you sure you want to DEACTIVATE this user?')||event.stopImmediatePropagation()"
                                                class="dropdown-item">
                                                <i data-feather='check-circle' class="mr-50"></i>
                                                <span>Disapprove</span>
                                            </a>
                                        @else
                                            <a wire:click.prevent="activate({{ $contact->id }})"
                                                onclick="confirm('Are you sure you want to ACTIVATE this customer?')||event.stopImmediatePropagation()"
                                                class="dropdown-item">
                                                <i data-feather='x-circle' class="mr-50"></i>
                                                <span>Approve</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                        <td colspan="8" style="text-align: center;"> No Record Found </td>                        </tr>
                    @endforelse
                </tbody>
            </table>


                <div class="mt-1">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<br>
