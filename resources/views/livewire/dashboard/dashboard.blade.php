<div>
    <div class="d-flex justify-content-between align-items-center mx-50 mb-2">
        <div>
            <a type="button" href="{{ route('dashboard.allocated.users') }}" class="btn-primary btn-lg rounded-2">Stock
                Holdings</a>
        </div>
        @if (Auth::check() && Auth::user()->account_type == 'Managers')

            <div>
                <a type="button" href="#" class="btn-success btn-lg rounded-2">
                    @if ($userRegion)
                        <b> {{ $userRegion ?? '' }} </b> Manager
                    @endif
                </a>
            </div>
        @endif
    </div>
    <div class="col-xl-12 col-md-12 col-12">
        <div class="card">
            <div class="pt-0 pb-2 d-flex justify-content-end align-items-center mx-50 row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="validationTooltip01" style="padding:10px">Start Date</label>
                        <input wire:model="start" name="startDate" type="date" class="form-control"
                            id="validationTooltip01" placeholder="YYYY-MM-DD HH:MM" required />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="validationTooltip01" style="padding:10px">End Date</label>
                        <input wire:model="end" name="startDate" type="date" class="form-control"
                            id="validationTooltip01" placeholder="YYYY-MM-DD HH:MM" required />
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('livewire.dashboard.distributorView')
    <div class="col-xl-12 col-md-12 col-12">
        @include('livewire.dashboard.topProducts')
        <div class="col-xl-12 col-md-12 col-12">
            @include('livewire.dashboard.statistics')
            <div class="row match-height">
                <div class="col-lg-8 col-12">
                    <div class="card card-company-table">
                        <div class="p-0 card-body">
                            <div class="table-responsive">
                                <div>
                                    @livewire('dashboard.line-chart')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('livewire.dashboard.currentLocation')
            </div>
            <div class="row match-height">
                <div class="col-lg-12 col-12">
                    <div class="card card-company-table">
                        <div class="p-0 card-body">
                            <div class="table-responsive">
                                <div>
                                    @livewire('individual.leads')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('livewire.dashboard.table')
        </div>
        <br />
    </div>
