@php
    use Illuminate\Support\Str;
@endphp


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
                    <select wire:model="regionFilter" class="form-control form-control-sm" id="selectRegion">
                        <option value="">All Regions</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2 user_role">
                <div class="form-group">
                    <label for="selectStatus">Status</label>
                    <select wire:model="statusFilter" class="form-control form-control-sm" id="selectStatus">
                        <option value="">All</option>
                        <option value="Approved">Approved</option>
                        <option value="Suspended">Disabled</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 d-flex justify-content-end">
                <div class="demo-inline-spacing">
                    <a href="{!! route('customer.create') !!}" class="btn btn-outline-secondary">Add Customer</a>
                    <button type="button" class="btn btn-icon btn-outline-primary" wire:click="export"
                        wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
                        <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="25" height="15"
                            data-toggle="tooltip" data-placement="top" title="Export Excel">Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-0 pb-2 d-flex justify-content-end align-items-center mx-90 row">
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
                <label for="">Filter By User: </label>
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
            <div class="card-datatable table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Zone/Region</th>
                            <th>Route</th>
                            <th >Created By</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $count => $contact)
                            <tr>
                            <td>
                                <div class="details-container" title="{{ $contact->customer_name ?? null }}" alt="{{ $contact->customer_name ?? null }}">
                                    {!! Str::limit($contact->customer_name, 15) !!} <br>
                                    @if ($contact->approval === 'Approved')
                                        <span class="badge badge-pill badge-light-success mr-1">Approved</span>
                                    @else
                                        <span class="badge badge-pill badge-light-warning mr-1">Pending</span>
                                    @endif
                                </div>
                            </td>
                            <td>{!! $contact->phone_number !!}</td>
                                <td title="{{ $contact->address ?? null }}">
                                    <div class="details-container">
                                        {{ Str::limit($contact->address ?? null) }}
                                       
                                    </div>
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
                                    {!! $contact->Creator->name ?? Auth::user()->name !!}
                                </td>

                                <td>
                                    {!! $contact->created_at ?? Auth::user()->name !!}
                                </td>

                                <td>
                                   

                                    <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle show-arrow " data-toggle="dropdown" style="background-color: #0186f5; color:white" >
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
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-1">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
