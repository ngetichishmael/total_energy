<div>
    
    @php
        use Illuminate\Support\Str;
    @endphp
    <style>
        .details-container {
            position: relative;
        }
    
        .details-icon {
            position: absolute;
            right: -5px;
            /* Adjust the position as desired */
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            /* Adjust the font size as desired */
            color: green;
            /* Adjust the color as desired */
            cursor: help;
        }
    </style>
    <div>
        <div class="mb-1 row">
            <div class="col-md-5">
                <label for="">Search by name, route, region</label>
                <input type="text" wire:model="search" class="form-control"
                    placeholder="Enter customer name, email address or phone number">
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="validationTooltip01">Start Date</label>
                    <input wire:model="start" name="startDate" type="date" class="form-control" id="validationTooltip01"
                        placeholder="YYYY-MM-DD HH:MM" required />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="validationTooltip01">End Date</label>
                    <input wire:model="end" name="startDate" type="date" class="form-control" id="validationTooltip01"
                        placeholder="YYYY-MM-DD HH:MM" required />
                </div>
            </div>
    
            <div class="col-md-1">
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
                            <th>Name</th>
                            <th>number</th>
                            <th>Address</th>
                            <th class="cell-fit">Zone, Region, Route</th>
                            <th>Created By</th>
                            <th>Order</th>
                            <th width="15%">Edit</th>
                            <th width="15%">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $count => $contact)
                                <td>{!! $count + 1 !!}</td>
                                <td title="{{ $contact->customer_name ?? null }}">
                                    <div class="details-container">
                                        {{ Str::limit($contact->customer_name ?? null, 10) }}
                                        <span class="details-icon">&#9432;</span>
                                    </div>
                                </td>
    
                                <td>{!! $contact->phone_number !!}</td>
                                <td title="{{ $contact->address ?? null }}">
                                    <div class="details-container">
                                        {{ Str::limit($contact->address ?? null, 10) }}
                                        <span class="details-icon">&#9432;</span>
                                    </div>
                                </td>
                                <td class="cell-fit">
                                    {!! $contact->Area->Subregion->Region->name ?? ' ' !!}
                                    ,
                                    {!! $contact->Area->Subregion->name ?? '' !!}
                                    ,
                                    {!! Str::camel($contact->Area->name ?? '') !!}
                                </td>
                                <td>
                                    {!! $contact->Creator->name ?? '' !!}
                                </td>
                                <td>
                                    <a href="{{ route('make.orders', ['id' => $contact->id]) }}"
                                        class="btn btn-sm btn-secondary">Order</a>
                                </td>
                                <td>
                                    <a href="{{ route('customer.edit', $contact->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                </td>
                                @if ($contact->route_code == 2)
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm">Approved</button>
                                    </td>
                                @else
                                    <td>
                                        @if ($contact->approval === 'Approved')
                                            <button wire:click.prevent="deactivate({{ $contact->id }})"
                                                onclick="confirm('Are you sure you want to DEACTIVATE this customer?')||event.stopImmediatePropagation()"
                                                type="button" class="btn btn-success btn-sm">Approved</button>
                                        @else
                                            <button wire:click.prevent="activate({{ $contact->id }})"
                                                onclick="confirm('Are you sure you want to ACTIVATE this customer?')||event.stopImmediatePropagation()"
                                                type="button" class="btn btn-danger btn-sm">Pending</button>
                                        @endif
                                    </td>
                                @endif
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
</div>
