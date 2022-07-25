<div>
   <div class="row mb-2">
      <div class="col-md-9">
         <label for="">Search</label>
         <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter name, email or phone number">
      </div>


      <div class="col-md-3">
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
               <tr>
                  <th width="1%">#</th>
                  {{-- <th width="5%">Image</th> --}}
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Account</th>
                  <th>Status</th>
                  <th width="12%">Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($users as $key => $user)
                  @if($user->businessID == Auth::user()->businessID)
                     <tr>
                        <td>{!! $key + 1 !!}</td>
                        <td>{!! $user->name !!}</td>
                        <td>
                           {!! $user->email !!}
                        </td>
                        <td>{!! $user->phone_number !!}</td>

                        <td>
                           {!! $user->account !!}
                        </td>
                        <td>{!! $user->status !!}</td>
                        <td>
                           {{-- <a href="{{ route('users.details', $user->proID) }}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a> --}}
                           <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                           <a href="{!! route('user.destroy', $user->id) !!}" class="btn btn-danger delete btn-sm"><i class="fas fa-trash"></i></a>
                        </td>
                     </tr>
                  @endif
               @endforeach
            </tbody>
         </table>
         {!! $users->links() !!}
      </div>
   </div>
</div>
