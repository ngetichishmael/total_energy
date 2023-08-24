<div class="mt-0">
    <section class="app-user-list" id="salesSection">
        <div class="card">
            <h5 class="card-header">Recent Volumes</h5>

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
                                        <span class="badge badge-pill badge-light-primary mr-1">
                                            {{ $sale->order_type ?? '' }}</span>
                                    @else
                                        <span class="badge badge-pill badge-light-danger mr-1">
                                            {{ $sale->order_type ?? '' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($sale->payment_status === 'PAID')
                                        <span
                                            class="badge badge-pill badge-light-success mr-1">{{ $sale->payment_status ?? '' }}</span>
                                    @else
                                        <span
                                            class="badge badge-pill badge-light-warning mr-1">{{ $sale->payment_status ?? '' }}</span>
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
                                <td>{{ $sale->Area->Subregion->Region->name ?? '' }}</td>
                                <td>{{ $sale->Creator->name ?? '' }}</td>
                                <td>
                                    @if ($sale->status === 'Active')
                                        <span
                                            class="badge badge-pill badge-light-success mr-1">{{ $sale->status ?? '' }}</span>
                                    @else
                                        <span class="badge badge-pill badge-light-warning mr-1">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $sale->updated_at->format('d-m-Y h:i A') ?? '' }}</td>
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
                            <th>Order Code</th>
                            <th>Sales Associates</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orderfullmentTotal as $key=>$sale)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $sale->order_code }}</td>
                                <td>{{ $sale->user()->pluck('name')->implode('') }}</td>
                                <td>{{ $sale->customer()->pluck('customer_name')->implode('') }}</td>
                                <!-- <td>{{ $sale->balance }}</td> -->
                                <td>
                                    @if ($sale->order_status === 'DELIVERED')
                                        <span
                                            class="badge badge-pill badge-light-success mr-1">{{ $sale->order_status ?? '' }}</span>
                                    @else
                                        <span
                                            class="badge badge-pill badge-light-warning mr-1">{{ $sale->order_status ?? '' }}</span>
                                    @endif
                                </td>
                                <td>{{ $sale->delivery_date }}</td>
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
</div>
