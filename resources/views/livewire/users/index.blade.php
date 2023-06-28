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
                            <th>Status</th>
                            <th width="12%">Edit</th>
                            <th width="12%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
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
                                <td>{!! $user->status !!}</td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                </td>
                                <td>
                                    @if ($user->status == 'Active')
                                        <button wire:click.prevent="deactivate({{ $user->id }})"
                                            onclick="confirm('Are you sure you want to DEACTIVATE this customer?')||event.stopImmediatePropagation()"
                                            type="button" class="btn btn-success btn-sm">Activate </button>
                                    @else
                                        <button wire:click.prevent="activate({{ $user->id }})"
                                            onclick="confirm('Are you sure you want to ACTIVATE this customer?')||event.stopImmediatePropagation()"
                                            type="button" class="btn btn-danger btn-sm">Suspend</button>
                                    @endif
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
