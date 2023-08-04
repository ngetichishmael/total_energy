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
                        <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
                    </div>
                </div>
                <div class="col-md-1 user_role">
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
       <!-- <div class="col-md-2">
             
               <select wire:model="statusFilter" class="form-control">
                  <option value="">All Statuses</option>
                  <option value="Pending Delivery">Pending Orders</option>
                  <option value="Complete Delivery">Complete Delivery</option>
                  <option value="Waiting acceptance">Waiting acceptance</option>
                  <option value="Partially Delivered">Partially Delivered</option>
               </select>
         </div> -->

       <div class="col-md-2">
            <button type="button" class="btn btn-icon btn-outline-success" wire:click="export"
                wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
                <img src="{{ asset('assets/img/excel.png') }}"alt="Export Excel" width="25" height="15"
                    data-toggle="tooltip" data-placement="top" title="Export Excel">Export
            </button>
        </div>
             
            </div>
        </div>

      <div class="pt-0 pb-2 d-flex justify-content-end align-items-center mx-50 row">
         <div class="col-md-2">
            <div>
               <label for="">Filter By Status: </label>
               <select wire:model="statusFilter" class="form-control">
                  <option value="">All Statuses</option>
                  <option value="Pending Delivery">Pending Orders</option>
                  <option value="Complete Delivery">Complete Delivery</option>
                  <option value="Waiting acceptance">Waiting acceptance</option>
                  <option value="Partially Delivered">Partially Delivered</option>
               </select>
            </div>
         </div>
      </div>
  
    <div class="card card-default">
        <div class="card-body">
            <div class="card-datatable">
                <table class="table table-striped table-bordered zero-configuration table-responsive">
                    <thead>
                        <th width="1%">#</th>
                        {{-- <th>Distributor</th> --}}
                        <th>Customer</th>
                        <th>Sales Person</th>
                        <th>Amount (Ksh.)</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @forelse ($pendingorders as $count => $order)

                            <tr>
                                {{-- @dd($order->id) --}}
                                <td>{{ $count + 1 }}</td>
                               {{-- <td>{{ $order->distributor()->pluck('name')->implode('') }}</td> --}}
                                <td title="{{ $order->Customer->customer_name ?? null }}">
                                    {{ Str::limit($order->Customer->customer_name ?? null, 30) }}</td>
{{--                                <td title="{{ $order->Customer->Area->Subregion->name ?? null }}">--}}
{{--                                    {{ Str::limit($order->Customer->Area->Subregion->name ?? null, 20) }}</td>--}}
{{--                                <td title="{{ $order->Customer->Area->Subregion->name ?? null }}">--}}
{{--                                    {{ Str::limit($order->Customer->Area->name ?? null, 20) }}</td>--}}
                                <td title="{{ $order->User->name ?? null }}">
                                    {{ Str::limit($order->User->name ?? null, 20) }}</td>
                                <td>{{ number_format($order->price_total) }}</td>
{{--                                <td>{{ number_format($order->balance) }}</td>--}}
                               <td>{{$order->created_at}}</td>
                               @php
                                  $orderStatus = strtolower($order->order_status);
                               @endphp

                               @if ($orderStatus == 'pending delivery')
                                  <td class="pending-order">Pending Order</td>
                               @elseif ($orderStatus == 'complete delivery')
                                  <td class="delivered-order">{{ $order->order_status }}</td>
                               @elseif ($orderStatus == 'waiting acceptance')
                                  <td class="waiting-acceptance">{{ $order->order_status }}</td>
                               @elseif ($orderStatus == 'partially delivery')
                                  <td class="partial-delivery">{{ $order->order_status }}</td>
                               @elseif ($orderStatus == 'not delivered')
                                  <td class="not-delivered">{{ $order->order_status }}</td>
                               @else
                                  <td>{{ $order->order_status }}</td>
                               @endif

                               <td>
                                  <div class="dropdown">
                                     <button class="btn btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" style="background-color:#1877F2; color:#ffffff;"  aria-expanded="false">
                                        <i data-feather='settings'></i>
                                     </button>
                                     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{!! route('orders.details', $order->order_code) !!}">View</a>

                                     </div>
                                  </div>
                               </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No pending orders available.</td>
                            </tr>
                            @endforelse
                    </tbody>
                </table>
            </div>
            {!! $pendingorders->links() !!}
        </div>
    </div>
    <br>
   <style>
      .pending-order {
         color: orange;
      }

      .delivered-order {
         color: green;
      }

      .waiting-acceptance {
         color: blue;

      }

      .partial-delivery {
         color: purple;
      }
      .not-delivered {
         color: orangered;
      }
   </style>
    @section('scripts')
    @endsection