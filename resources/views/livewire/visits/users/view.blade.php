<div>
    <div class="card">
        <h5 class="card-header"></h5>
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
            <div class="col-md-3 user_role">
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
            <div class="col-md-2">
                <div class="form-group">
                    <label for="validationTooltip01">Start Date</label>
                    <input wire:model="start" name="startDate" type="date" class="form-control" id="validationTooltip01" placeholder="YYYY-MM-DD HH:MM" required />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="validationTooltip01">End Date</label>
                    <input wire:model="end" name="endDate" type="date" class="form-control" id="validationTooltip01" placeholder="YYYY-MM-DD HH:MM" required />
                </div>
            </div>
            <div class="col-md-2">
                    <button type="button" class="btn btn-icon btn-outline-success" wire:click="export"
                        wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel" width="25" height="15">
                        <img src="{{ asset('assets/img/excel.png') }}"alt="Export Excel" width="15" height="15"
                            data-toggle="tooltip" data-placement="top" title="Export Excel">Export
                    </button>
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
                            <th>Sales Associate</th>
                            <th>Customer Name</th>
                            <th>Start/Stop Time</th>
                            <th>Duration</th>
                            <th>Date</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($visits as $count => $visit)
                        <tr>
                            <td>{!! $count + 1 !!}</td>
                            <td>{!! $visit->name !!}</td>
                            <td>{!! $visit->customer_name !!}</td>
                            <td>
                                <div class="badge badge-pill badge-secondary">{{ $visit->start_time ?? '' }}</div> <b>-</b>
                                <div class="badge badge-pill badge-secondary">{{ $visit->stop_time ?? '' }}</div>
                            </td>
                            <td>
                                <div class="badge badge-pill badge-dark">{{ $this->formatDuration($visit->duration_seconds) ?? '' }}</div>
                            </td>
                            
                            <td>{{ $visit->formatted_date }}</td>
                            <td> </td>

                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center;">No Record found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-1">
                    {{ $visits->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<br>