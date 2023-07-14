<div>
    <div class="mb-2 row">
        <div class="col-md-9">
            <label for="">Search</label>
            <input wire:model.debounce.300ms="search" type="text" class="form-control"
                placeholder="Enter name, email or phone number">
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
            <div class="pt-0 card-datatable">
                <table class="table table-striped table-bordered zero-configuration table-responsive">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
{{--                            <th>Region</th>--}}
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th width="12%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $key => $admin)
                            <tr>
                                <td>{!! $key + 1 !!}</td>
{{--                                <td>{!! $admin->Region->name ?? ' ' !!}</td>--}}
                                <td>{!! $admin->name !!}</td>
                                <td>
                                    {!! $admin->email !!}
                                </td>
                                <td>{!! $admin->phone_number !!}</td>
                                <td>{!! $admin->status !!}</td>
                                <td>
                                   <div class="dropdown" >
                                      <button  class="btn btn-primary dropdown-toggle mr-2" type="button" id="dropdownMenuButton" data-bs-trigger="click" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                         <i data-feather="settings"></i>
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                         <a href="{{ route('user.edit', $admin->id) }}" type="button" class="dropdown-item btn btn-sm" style="color: #6df16d;font-weight: bold"><i data-feather="edit"></i> &nbsp;Edit</a>
                                         <a href="{{ route('visit.target.show', $admin->id) }}" type="button" class="dropdown-item btn btn-sm" style="color: #7cc7e0; font-weight: bold"><i data-feather="eye"></i>&nbsp; Visits</a>             
                                    @if ($admin->status === 'Active')
                                        <a wire:click.prevent="deactivate({{ $admin->id }})"
                                            onclick="confirm('Are you sure you want to DEACTIVATE this user?')||event.stopImmediatePropagation()"
                                            type="button" class="dropdown-item btn btn-sm me-2" style="color: #e5602f;font-weight: bold" ><i data-feather="pause"></i>&nbsp;Suspend</a>
                                    @else
                                        <a wire:click.prevent="activate({{ $admin->id }})"
                                            onclick="confirm('Are you sure you want to ACTIVATE this user?')||event.stopImmediatePropagation()"
                                            type="button" class="dropdown-item btn btn-sm me-2" style="color:  #54a149; font-weight: bold"><i data-feather="check"></i>&nbsp;Activate </a>
                                    @endif
                                      </div>
                                   </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-1">{!! $admins->links() !!}</div>
        </div>
    </div>
    <br>
</div>
