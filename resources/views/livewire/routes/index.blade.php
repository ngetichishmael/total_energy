<div>
    <div class="card">
        <h5 class="card-header">Routes</h5>
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
            <div class="col-md-4">
                <!-- Search Input -->
                <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                    <input wire:model.debounce.500ms="search" type="text" class="form-control" placeholder="Search" />
                </div>
            </div>
            <div class="col-md-2">
                <!-- Per Page Dropdown -->
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

            <div class="col-md-2">
                <!-- Add Route Button -->
                <a class="btn btn" style="background-color:#1877F2; color:#ffffff;" href="{!! route('routes.create') !!}">
                    <i data-feather="user-plus" style="padding:2px"></i> Add Route
                </a>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-body">
            <!-- Route Table -->
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="1%">#</th>
                        <th>Name</th>
                        <th>Sales Name</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($routes as $count => $route)
                        <tr>
                            <td>{!! $count + 1 !!}</td>
                            <td>{!! $route->name !!}</td>
                            <td>{!! $route->user->name !!}</td>
                            <td>{!! $route->status !!}</td>
                            <td>{!! $route->Type !!}</td>
                            <td>{!! $route->start_date !!}</td>
                            <td>{!! $route->end_date !!}</td>
                        </tr>
                    @empty
                        <tr>
                             <td colspan="7" class="text-center">No routes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-1">{!! $routes->links() !!}</div>
        </div>
    </div>
</div>
<br>