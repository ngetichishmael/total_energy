<div>
    <div class="row mb-2">
        <div class="col-md-5">
            <label for="">Search</label>
            <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Search ...">
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
            <div class="mt-1">
                <a href="{{ route('visit.target.create') }}" type="button" class="btn btn-primary">
                    New Target
                </a>
            </div>
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
                        <th>Success Ratio</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($targets as $key=>$target)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $target->name }}</td>
                            <td>{{ $target->TargetSale->SalesTarget }}</td>
                            <td>{{ $target->TargetSale->AchievedSalesTarget }}</td>
                            <td>{{ $target->TargetSale->Deadline }}</td>
                            <td>
                                {{ $this->getSuccessRatio($target->TargetSale->AchievedSalesTarget, $target->TargetSale->SalesTarget) }}%
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button style="background-color: #007ec4;color:white"
                                        class="btn btn-md  dropdown-toggle mr-2" type="button" id="dropdownMenuButton"
                                        data-bs-trigger="click" aria-haspopup="true" aria-expanded="false"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                        <i data-feather="settings"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('salestarget.edit', $target->user_code) }}" type="button"
                                            class="dropdown-item btn btn-sm" style="color:#7cc7e0 ;font-weight: bold"><i
                                                data-feather="edit"></i>
                                            &nbsp;Edit</a>
                                        <a href="{{ route('sales.target.show', [
                                            'sale' => $target->user_code,
                                        ]) }}"
                                            type="button" class="dropdown-item btn btn-sm"
                                            style="color:#6df16d ; font-weight: bold"><i data-feather="eye"></i>&nbsp;
                                            View</a>
                                    </div>
                                </div>

                            </td>
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
