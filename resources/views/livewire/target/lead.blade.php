<div>
    <div class="row mb-2">
        <div class="col-md-5">
            <label for="">Search</label>
            <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Search ...">
            <!-- Button trigger modal -->
            <div class="mt-1">
                <a href="{{ route('sales.target.create') }}" type="button" class="btn btn-primary">
                    New Target
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <label for="">Items Per</label>
            <select wire:model="perPage" class="form-control">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="">Time Frame</label>
            <select wire:model="timeFrame" class="form-control">
                <option value="quarter">Quarter</option>
                <option value="half_year">Half Year</option>
                <option value="year">Year</option>
            </select>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="1%">#</th>
                        <th>Sales Person</th>
                        <th>Target</th>
                        <th>Achieved</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Success Ratio</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($targets as $target)
                        <tr>
                            <td>{{ $target->id }}</td>
                            <td>{{ $target->User()->pluck('name')->implode('')  }}</td>
                            <td>{{ $target->LeadsTarget }}</td>
                            <td>{{ $target->AchievedLeadsTarget }}</td>
                            <td>{{ $target->Deadline }}</td>
                            <td>
                                @if ($today < $target->Deadline)
                                    <span class="btn btn-flat-success">Active</span>
                                @else
                                    <span class="btn btn-flat-danger">Expired</span>
                                @endif
                            </td>
                            <td>
                                {{ $this->getSuccessRatio($target->AchievedVisitsTarget, $target->VisitsTarget) }}%
                            </td>
                            <td><a href="{{ route('leadstarget.edit',$target->user_code) }}" class="btn btn-outline-info btn-sm">Edit</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No Targets Available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
