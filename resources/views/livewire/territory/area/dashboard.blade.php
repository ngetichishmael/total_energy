<div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Routes</h5>
        </div>
        <div class="card-body pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
            <div class="col-md-4 user_role">
                <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search" />
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
            <div class="col-md-2 d-flex justify-content-end">
                <div class="demo-inline-spacing">
                    <button type="button" class="btn btn-icon btn-outline-success" wire:click="export"
                        wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
                        <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="25" height="15"
                            data-toggle="tooltip" data-placement="top" title="Export Excel">Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-inverse">
                <div class="card-body">
                    <div class="card-body">
                        <table id="data-table-default" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="1%">#</th>
                                    <th>Name</th>
                                    <th>Region</th>
                                    <th>Zone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $key => $area)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $area->name }}</td>
                                        <td>{{ $area->Subregion->name }}</td>
                                        <td>{{ $area->Subregion->Region->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $areas->links() }}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-body">
                    <h4 class="card-title">Add Route</h4>
                    <form method="POST" action="{{ route('areas.store') }}" style="gap: 20px;">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-2 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">Route</label>
                                                    <input type="text" id="first-name-column" class="form-control"
                                                        placeholder="Route" name="name" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="select-country">Region</label>
                                                    <select class="form-control select2" id="select-country"
                                                        name="subregion" required>
                                                        <option value="">Select Regions</option>
                                                        @foreach ($subregions as $subregion)
                                                            <option value="{{ $subregion->id }}">{{ $subregion->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 col-12 d-flex flex-sm-row flex-column" style="gap: 20px;">
                            <button type="submit" class="mb-1 mr-0 btn btn-success mb-sm-0 mr-sm-1"> Add Route</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
