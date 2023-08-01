<div>
<div class="card">
            <h5 class="card-header"></h5>
            <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                <div class="col-md-4 user_role">
                    <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="search"></i></span>
                        </div>
                        <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
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
  
             
            </div>
        </div>

    <div class="card card-default">
        <div class="card-body">
        <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="1%">#</th>
                        <th>OrderID</th>
                        <th>Customer</th>
                        <th>Sales Agents</th>
                        <th>Total Paid</th>
                        <th>Date</th>
                        <th>Approved ?</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deliveries as $count => $deliver)
                        <tr>
                            <td>{!! $count + 1 !!}</td>
                            <td>{!! $deliver->order_code !!}</td>
                            <td>{!! $deliver->Customer->customer_name ?? ' ' !!}</td>
                            <td>{!! $deliver->User->name ?? '' !!}</td>
                            <td>{!! number_format(($deliver->Order->price_total ?? 0) - ($deliver->Order->balance ?? 0)) !!}</td>
                            <td>{!! $deliver->updated_at !!}</td>
                            <td>
                                @if ($deliver->approval == 0)
                                    <button wire:click.prevent="approve({{ $deliver->id }})"
                                        onclick="confirm('Are you sure you want to APPROVE this order?') || event.stopImmediatePropagation()"
                                        type="button" class="btn btn-danger btn-sm">NO</button>
                                @else
                                    <button type="button" class="btn btn-success btn-sm">YES</button>
                                @endif
                            </td>
                            <td><a href="{!! route('PaidPayment.show', ['paid' => $deliver->order_code]) !!}" class="btn btn-sm btn-success">View</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Payment found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-1">{!! $deliveries->links() !!}</div>
        </div>
    </div>
</div>