<div>
       
<div class="card">
            <h5 class="card-header"></h5>
            <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                <div class="col-md-3 user_role">
                    <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="search"></i></span>
                        </div>
                        <input  wire:model.debounce.300ms="search" type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
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
       

        
             <div class="col-md-6 d-flex justify-content-end">
                    <div class="demo-inline-spacing">
                        <a href="{{ route('sales.target.create') }}" class="btn btn-outline-secondary">Add Target</a>
             
                    </div>
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
                    <button type="button" class="btn btn-sm dropdown-toggle show-arrow " data-toggle="dropdown" style="background-color:#1877F2; color:#ffffff;">
                                        <i data-feather="eye"></i>
                                    </button>
                        <div class="dropdown-menu">
                       
                            <a class="dropdown-item" href="{{ route('salestarget.edit', $target->user_code) }}">
                                <i data-feather='edit' class="mr-50"></i>
                                <span>Edit</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('sales.target.show', [
                                            'sale' => $target->user_code,
                                        ]) }}">
                                                <i data-feather='eye' class="mr-50"></i>
                                                <span>View</span>
                                            </a>
                         
                
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
