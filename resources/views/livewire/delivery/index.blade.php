<div>
   <div class="row mb-1">
      <div class="col-md-10">
         <label for="">Search</label>
         <input type="text" wire:model="search" class="form-control" placeholder="Enter customer name,order number or sales person">
      </div>
      <div class="col-md-2">
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
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>OrderID</th>
               <th>Customer</th>
               <th>Delivery By</th>
               <th>Date</th>
               <th>Status</th>
               <th>Action</th>
            </thead>
            <tbody>
               <tr>
                  @foreach($deliveries as $count=>$deliver)
                     <tr>
                        <td>{!! $count+1 !!}</td>
                        <td>
                           {!! $deliver->order_code !!}
                        </td>
                        <td>{!! $deliver->customer_name !!}</td>
                        <td>{!! $deliver->name !!}</td>
                        <td>{!! $deliver->delivery_date !!}</td>
                        <td><a href="" class="badge {!! $deliver->delivery_status !!}">{!! $deliver->delivery_status !!}</a></td>
                        <td><a href="" class="btn btn-sm btn-success">view</a></td>
                     </tr>
                  @endforeach
               </tr>
            </tbody>
         </table>
         {!! $deliveries->links() !!}
      </div>
   </div>
</div>
@section('scripts')

@endsection
