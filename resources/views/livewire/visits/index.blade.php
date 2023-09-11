<div class="card">
    <h5 class="card-header"></h5>
    <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
        <div class="col-md-3 user_role">
            <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i data-feather="search"></i></span>
                </div>
                <input wire:model.debounce.300ms="search" type="text" id="fname-icon" class="form-control"
                    name="fname-icon" placeholder="Search" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="validationTooltip01">Start Date</label>
                <input wire:model="start" name="startDate" type="date" class="form-control" id="validationTooltip01"
                    placeholder="YYYY-MM-DD HH:MM" required />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="validationTooltip01">End Date</label>
                <input wire:model="end" name="endDate" type="date" class="form-control" id="validationTooltip01"
                    placeholder="YYYY-MM-DD HH:MM" required />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="">Perpage: </label>
                <select wire:model="perPage" class="form-control">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="btn-group">
                <button type="button" class="btn btn-icon btn-outline-primary dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" wire:loading.attr="disabled">
                    <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="15" height="15">
                    Export
                </button>
                <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" wire:click="export" id="exportExcelBtn">Excel</a>
                    <a class="dropdown-item" wire:click="exportCSV" id="exportCsvBtn">CSV</a>
                    <a class="dropdown-item" wire:click="exportPDF" id="exportPdfBtn">PDF</a>
                    <!-- <a class="dropdown-item" wire:click="printAndRedirect" id="printBtn">Print</a> -->
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.stickymenu')
<br>
<div class="row">
  

<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th>Visits</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visits as $key => $visit)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $visit->name ?? '' }}</td>
                                    <td>{{ $visit->account_type }}</td>
                                    <td>{{ $visit->checkings_count }}</td>
                                    <td><a href="" class="btn btn-sm"
                                    style="background-color: #1877F2; color:white"  >View</a></td>
                                </tr>
                            @endforeach

                        </tbody>
                </table>
                </div>

                {{-- <div class="mt-1">{!! $suppliers->links() !!}</div> --}}
            </div>
        </div>
    </div>
</div>
