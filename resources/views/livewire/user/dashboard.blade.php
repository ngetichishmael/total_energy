<div class="row">
    @include('partials.stickymenu')
    <div class="col-md-8">
        <div class="card card-inverse">
           <div class="card-body">
              <table id="data-table-default" class="table table-striped table-bordered">
                 <thead>
                    <tr>
                       <th>#</th>
                       <th>User Type</th>
                       <th>Number of Users</th>
                       <th>Action</th>
                    </tr>
                 </thead>
                 <tbody>
               @foreach ($usercount as $key=>$user)
               <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $user->account_type }}</td>
                  <td>{{ $user->count}}</td>
                  <td></td>
              </tr>
               @endforeach
                    
                 </tbody>
              </table>
           </div>
        </div>
     </div>
   </div>