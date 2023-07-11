<div>
    <div class="mb-2 row">
        <div class="col-md-9">
            <label for="">Search</label>
            <input wire:model.debounce.300ms="search" type="text" class="form-control"
                placeholder="Enter name, email or phone number">
        </div>
        <div class="col-md-3 col-12">
            <div class="form-group">
                <label for="select-country">Sales Team Category</label>
                <select wire:model="account" class="form-control" id="select-country" name="account_type" required>
                    <option value="">Select Category</option>
                    <option value="Admin">Administator</option>
                    <option value="Manager">Manager</option>
                    <option value="Sales">Sales Agent</option>
                    <option value="Lube Sales Executive">Lube Sales Executive</option>
                    <option value="Lube Merchandizers">Lube Merchandizers</option>
                </select>
            </div>
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
            <div class="pt-0 card-datatable table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Region</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Account Type</th>
                            <th width="12%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr
                                @if ($user->status !== 'Active') style="text-decoration: line-through; color: red;" @endif>
                                <td>{!! $key + 1 !!}</td>
                                <td>
                                    @if ($user->route_code == 0)
                                        General
                                    @else
                                        {!! $user->Region->name ?? ' ' !!}
                                    @endif
                                </td>
                                <td>{!! $user->name !!}</td>
                                <td>
                                    {!! $user->email !!}
                                </td>
                                <td>{!! $user->phone_number !!}</td>
                                <td>{!! $user->account_type !!}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i data-feather='settings'></i>
                                        </button>
                                        <div class="dropdown-menu g-25" aria-labelledby="dropdownMenuButton"
                                            style="gap:20">
                                            <a class="dropdown-item btn btn-flat-primary btn-sm"
                                                href="{{ route('user.edit', $user->id) }}">Edit</a>
                                            <a class="dropdown-item btn btn-flat-primary btn-sm"
                                                href="{{ route('visit.target.show', $user->user_code) }}">Visits</a>
                                            @if ($user->status === 'Active')
                                                <a class="dropdown-item btn btn-danger btn-sm"
                                                    wire:click.prevent="activate({{ $user->id }})"
                                                    onclick="confirm('Are you sure you want to ACTIVATE this customer?') || event.stopImmediatePropagation()"
                                                    type="button">Suspend</a>
                                            @else
                                                <a class="dropdown-item btn btn-success btn-sm"
                                                    wire:click.prevent="deactivate({{ $user->id }})"
                                                    onclick="confirm('Are you sure you want to DEACTIVATE this customer?') || event.stopImmediatePropagation()"
                                                    type="button">Activate</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="mt-1">{!! $users->links() !!}</div>
        </div>
    </div>
</div>
