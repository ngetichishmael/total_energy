<div class="mt-0">
    <section class="app-user-list" id="salesSection">
        <div class="card">
            <h5 class="card-header">Recent Sales</h5>
         
        </div>

        <div class="card">
            <div class="pt-0 card-datatable table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>OrderID</th>
                            <th>Customer</th>
                            <th>Sales Associates</th>
                            <th>Balance </th>
                            <th>Type</th>
                            <th>Payment Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $key=>$sale)
                            <tr>
                                <td>{{ $sale->order_code }}</td>
                                <td>{{ $sale->user()->pluck('name')->implode('') }}</td>
                                <td>{{ $sale->customer()->pluck('customer_name')->implode('') }}</td>
                                <td>{{ $sale->balance }}</td>
                                <td>
                                    @if ($sale->order_type === 'Pre Order')
                                        <span class="badge badge-pill badge-light-primary mr-1"> {{ $sale->order_type ?? ''}}</span>
                                    @else
                                        <span class="badge badge-pill badge-light-danger mr-1"> {{ $sale->order_type ?? ''}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($sale->payment_status === 'PAID')
                                        <span class="badge badge-pill badge-light-success mr-1">{{ $sale->payment_status ?? '' }}</span>
                                    @else
                                        <span class="badge badge-pill badge-light-warning mr-1">{{ $sale->payment_status ?? '' }}</span>
                                    @endif
                                </td>
                                <td>{{ $sale->updated_at->format('d-m-Y h:i A') }}</td>
                            </tr>
                        @empty
                            <x-emptyrow>
                                6
                            </x-emptyrow>
                        @endforelse
                    </tbody>
                </table>
              
            </div>
        </div>
    </section>

    <section class="app-user-list" id="buyingCustomersSection">
        <div class="card">
            <h5 class="card-header">Recent Customers</h5>
        
        </div>

        <div class="card">
            <div class="pt-0 card-datatable table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                     
                            <th>Customer</th>
                            <th>Address</th>
                            <th>Type</th>
                            <th>Region</th>
                            <th>Registered By</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customersCountTotal as $key=>$sale)
                            <tr>
                                <td>{{ $sale->customer_name ?? '' }}</td>
                                <td>{{ Str::limit($sale->address ?? '', 25) }}</td>
                                <td>{{ $sale->customer_group ?? '' }}</td>
                                <td>{{ $sale->Region->name ?? '' }}</td>
                                <td>{{ $sale->Creator->name ?? '' }}</td>
                                <td>
                                    @if ($sale->status === 'Active')
                                        <span class="badge badge-pill badge-light-success mr-1">{{ $sale->status ?? '' }}</span>
                                    @else
                                        <span class="badge badge-pill badge-light-warning mr-1">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $sale->updated_at->format('d-m-Y h:i A') ?? ''}}</td>
                            </tr>
                        @empty
                            <x-emptyrow>
                                6
                            </x-emptyrow>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <section class="app-user-list" id="orderFulfillmentSection">
        <div class="card">
            <h5 class="card-header">Recent Deliveries</h5>
        </div>

        <div class="card">
            <div class="pt-0 card-datatable table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Delivery Code</th>
                            <th>Order Code</th>
                            <th>Sales Associates</th>
                            <th>Customer</th>
                            <!-- <th>Balance </th> -->
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orderfullmentTotal as $key=>$sale)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $sale->delivery_code }}</td>
                                <td>{{ $sale->order_code }}</td>
                                <td>{{ $sale->user()->pluck('name')->implode('') }}</td>
                                <td>{{ $sale->customer()->pluck('customer_name')->implode('') }}</td>
                                <!-- <td>{{ $sale->balance }}</td> -->
                                <td>
                                    @if ($sale->delivery_status === 'DELIVERED')
                                        <span class="badge badge-pill badge-light-success mr-1">{{ $sale->delivery_status ?? '' }}</span>
                                    @else
                                        <span class="badge badge-pill badge-light-warning mr-1">{{ $sale->delivery_status ?? '' }}</span>
                                    @endif
                                </td>
                                <td>{{ $sale->delivered_time }}</td>
                            </tr>
                        @empty
                            <x-emptyrow>
                                6
                            </x-emptyrow>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<!-- 
    <section class="app-user-list" id="systemUsers">
        <div class="card">
            <h5 class="card-header">System Users</h5>
            <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="selectSmall">Select Per Page</label>
                        <select wire:model='perOrderFulfilment' class="form-control form-control-sm" id="selectSmall">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="pt-0 card-datatable table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <td>#</td>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Region</th>
                            <th>Account Type</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($getUserTotal as $key=>$sale)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $sale->name }}</td>
                                <td>{{ $sale->phone_number ?? '' }}</td>
                                <td>{{ $sale->email ?? '' }}</td>
                                <td>{{ $sale->Region->name ?? '' }}</td>
                                <td>{{ $sale->account_type ?? '' }}</td>
                                <td>{{ $sale->status }}</td>
                                <td>{{ $sale->created_at }}</td>
                            </tr>
                        @empty
                            <x-emptyrow>
                                6
                            </x-emptyrow>
                        @endforelse
                    </tbody>
                </table>
                {{ $orderfullmentTotal->links() }}
            </div>
        </div>
    </section>
    <section class="app-user-list" id="creditors">
        <div class="card">
            <h5 class="card-header">Overdue Creditors</h5>
            <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="selectSmall">Select Per Page</label>
                        <select wire:model='perVansale' class="form-control form-control-sm" id="selectSmall">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="pt-0 card-datatable table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Order Code</th>
                            <th>Customer Name</th>
                            <th>Created By </th>
                            <th>Balance </th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $key=>$sale)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $sale->order_code }}</td>
                                <td>{{ $sale->customer()->pluck('customer_name')->implode('') }}</td>
                                <td>{{ $sale->user()->pluck('name')->implode('') }}</td>
                                <td>{{ $sale->balance }}</td>
                                <td>{{ $sale->payment_status }}</td>
                                <td>{{ $sale->updated_at }}</td>
                            </tr>
                        @empty
                            <x-emptyrow>
                                6
                            </x-emptyrow>
                        @endforelse
                    </tbody>
                </table>
            
            </div>
        </div>
    </section> -->
</div>
