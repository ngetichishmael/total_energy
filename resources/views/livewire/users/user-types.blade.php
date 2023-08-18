<div>
<div class="content-header row"style="padding-left:6%; padding-right:5%">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top" >
            <div class="col-12">
               <!-- <h2 class="content-header-title float-start mb-0">Users Roles</h2> -->
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                     <li class="breadcrumb-item active"><a href="/users-Roles">Users</a></li>
                  </ol>
               </div>
            </div>

         </div>
      </div>
   </div>
   @include('partials._messages')
   <div class="row" style="padding-left:6%; padding-right:5%">
    <div class="col-md-11">
        <div class="card card-inverse">
           <div class="card-body">
              <table id="data-table-default" class="table table-striped table-bordered">
                 <thead>
                    <tr>
                       <th width="1%">#</th>
                       <th>Account Types</th>
                       <th width="20%">Number of Users</th>
                       <th>Actions</th>
                    </tr>
                 </thead>
                 <tbody>

                    @foreach ($lists as $list)
                    <tr>
                       <td>{!! $count++ !!}</td>
                       <td>{!! $list !!}</td>
                       <td>{{ $counts[$list] }}</td>
                       <td>
                          <div class="d-flex" style="gap:10px">
                               @if($list == 'Admin')
                                <a href="{{ route('users.admins') }}" class="btn btn btn-sm" style="background-color:#1877F2; color:#ffffff;">View</a>
                                @elseif($list == 'Lube Sales Executive')
                                <a href="{{ route('LubeSalesExecutive') }}" class="btn btn btn-sm" style="background-color:#1877F2; color:#ffffff;">View</a>
                                @elseif($list == 'Distributors')
                                <a href="{{ route('Distributors') }}" class="btn btn btn-sm" style="background-color:#1877F2; color:#ffffff;">View</a>
                                @elseif($list == 'Lube Merchandizers')
                                <a href="{{ route('lubemerchandizer') }}" class="btn btn btn-sm" style="background-color:#1877F2; color:#ffffff;">View </a>
                                @elseif($list == 'Managers')
                                <a href="{{ route('Managers') }}" class="btn btn btn-sm" style="background-color:#1877F2; color:#ffffff;">View </a>

                           @endif
                          </div>
                       </td>
                    </tr>
                    @endforeach
                 </tbody>
              </table>
           </div>
        </div>
     </div>
   </div>
</div>
