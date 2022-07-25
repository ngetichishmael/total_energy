<div>
   <div class="row mb-1">
      <div class="col-md-10">
         <label for="">Search</label>
         <input type="text" wire:model="search" class="form-control" placeholder="Enter customer namer">
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
               <th>Customer</th>
               <th>Type</th>
               <th>Time Spent</th>
               <th>Date</th>
               <th>Employee</th>
               {{-- <th width="15%">Action</th> --}}
            </thead>
            <tbody>
               @foreach($checkins as $count=>$checkin)
                  <tr>
                     <td>{!! $count+1 !!}</td>
                     <td>{!! $checkin->customer_name !!}</td>
                     <td>{!! $checkin->checkin_type !!}</td>
                     <td>{!! $checkin->start_time !!} - {!! $checkin->stop_time !!}</td>
                     <td>{!! $checkin->created_at !!}</td>
                     <td>{!! $checkin->name !!}</td>
                     {{-- <td>
                        <a href="" class="btn btn-sm btn-success btn-block">View</a>
                     </td> --}}
                  </tr>
               @endforeach
            </tbody>
         </table>
         {!! $checkins->links() !!}
      </div>
   </div>
</div>
@section('scripts')

@endsection
