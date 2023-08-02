<div>
    <div class="card">
            <h5 class="card-header"></h5>
            <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                <div class="col-md-2 user_role">
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
               
                <div class="col-md-2 user_role">
                    <div class="form-group">
                        <label for="selectSubregion">Subregion</label>
                        <select wire:model="selectedSubregion" class="form-control form-control-sm" id="selectSubregion">
                            <option value="">All Subregions</option>
                            @foreach ($subregions as $subregion)
                                <option value="{{ $subregion->id }}">{{ $subregion->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <a href="{!! route('user.create') !!}" class="btn btn-gradient"  style="background-color:#1877F2; color:#ffffff;"> <i data-feather="user-plus" style="padding:2px"></i>  Add User</a>
                </div>
             
            </div>
        </div>
        
            <div class="card card-default">
                <div class="card-body">
                    <div class="pt-0 card-datatable">
                    <table class="table table-striped table-bordered zero-configuration table-responsive">
            <thead>
                <tr>
                    <th width="1%">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Region</th>
                    <th>Sub-Reg</th>
                    <th>Area</th>
                    <th>Status</th>
                    <th width="12%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($sales->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No result found</td>
                    </tr>
                @else
                    @foreach ($sales as $key => $user)
                        <tr>
                            <td>{!! $key + 1 !!}</td>
                            <td>{!! $user->name !!}</td>
                            <td>{!! $user->email !!}</td>
                            <td>{!! $user->phone_number !!}</td>
                            <td>{!! $user->Region->name ?? '' !!}</td>
                            <td>{{ $user->area->subregion->name ?? ''}}</td>
                            <td>{{ $user->area->name ?? ''}}</td>
                            <td>
                                @if ($user->status == 'Active')
                                    <span class="badge badge-pill badge-light-success mr-1">Active</span>
                                @else
                                    <span class="badge badge-pill badge-light-warning mr-1">Disabled</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle show-arrow " data-toggle="dropdown" style="background-color: #1877F2; color:white" >
                                    <i data-feather="settings"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('user.view', $user->user_code) }}">
                                            <i data-feather="eye" class="mr-50"></i>
                                            <span>View</span>
                                        </a>
                                        <a class="dropdown-item" href="{{ route('user.edit', $user->user_code) }}">
                                            <i data-feather='edit' class="mr-50"></i>
                                            <span>Edit</span>
                                        </a>
                                        @if ($user->status == 'Active')
                                            <a wire:click.prevent="deactivate({{ $user->id }})"
                                                onclick="confirm('Are you sure you want to DEACTIVATE this user?')||event.stopImmediatePropagation()"
                                                class="dropdown-item">
                                                <i data-feather='check-circle' class="mr-50"></i>
                                                <span>Suspend</span>
                                            </a>
                                        @else
                                            <a wire:click.prevent="activate({{ $user->id }})"
                                                onclick="confirm('Are you sure you want to ACTIVATE this user?')||event.stopImmediatePropagation()"
                                                class="dropdown-item">
                                                <i data-feather='x-circle' class="mr-50"></i>
                                                <span>Activate</span>
                                            </a>
                                        @endif
                                
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

            </div>
            <div class="mt-1">{!! $sales->links() !!}</div>
        </div>
    </div>

    <br>
</div>