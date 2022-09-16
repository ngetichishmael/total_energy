<div>
   <div class="row mb-1">
      <div class="col-md-10">
         <label for="">Search</label>
         <input type="text" wire:model="search" class="form-control" placeholder="Enter customer name">
      </div>
      <div class="col-md-2">
         <label for="">Items Per</label>
         <select wire:model="perPage" class="form-control">`
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="100">100</option>
            <option value="100">200</option>
         </select>
      </div>
   </div>
   <div class="card card-default">
      <div class="card-body">
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Order Type</th>
               {{-- <th>OrderID</th> --}}
               <th>Customer</th>
               <th>Sales Person</th>
               <th>Amount</th>
               <th>Balance</th>
               <th>QTY</th>
               <th>Status</th>
               <th>Action</th>
            </thead>
            <tbody>
               @foreach($orders as $count=>$order)
                  <tr>
                     <td>{!! $count+1 !!}</td>
                     <td>{!! $order->order_type !!}</td>
                     {{-- <td>{!! $order->order_id !!}</td> --}}
                     <td>{!! $order->customer_name !!}</td>
                     <td>{!! $order->name !!}</td>
                     <td>ksh {!! number_format($order->price_total) !!}</td>
                     <td>ksh {!! number_format($order->balance) !!}</td>
                     <td>{!! $order->qty !!}</td>
                     <td>{!! $order->order_status !!}</td>
                     <td>
                        <a href="{!! route('orders.details',$order->order_code) !!}" class="btn btn-warning btn-sm">View</a>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
         {!! $orders->links() !!}
      </div>
   </div>
</div>
@section('scripts')

@endsection
