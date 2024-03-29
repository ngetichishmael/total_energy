<div>
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
                    <input wire:model="start" name="startDate" type="date" class="form-control"
                        id="validationTooltip01" placeholder="YYYY-MM-DD HH:MM" required />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="validationTooltip01">End Date</label>
                    <input wire:model="end" name="startDate" type="date" class="form-control"
                        id="validationTooltip01" placeholder="YYYY-MM-DD HH:MM" required />
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
                    <button type="button" class="btn btn-icon btn-outline-primary dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" wire:loading.attr="disabled">
                        <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="15" height="15">
                        Export
                    </button>
                    <div class="dropdown-menu dropdown-menu-left">
                        <a class="dropdown-item" wire:click="export" id="exportExcelBtn">Excel</a>
                        <a class="dropdown-item" wire:click="exportCSV" id="exportPdfBtn"> CSV</a>
                        <a class="dropdown-item" wire:click="exportPDF" id="exportCsvBtn">PDF</a>
                        <!-- <a class="dropdown-item" wire:click="printAndRedirect" id="printBtn">Print</a> -->

                    </div>
                </div>
            </div>

        </div>
    </div>


</div>
@include('partials.stickymenu')
<br>
<div class="row">

    <div class="col-md-12">
        <div class="card card-inverse">
            <div class="card-body">
                <div class="d-flex flex-row flex-nowrap overflow-auto">
                    <table id="data-table-default" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Total Volume</th>
                                <th>Customer Name</th>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vansales as $vansale)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ $vansale->order_code }}</td>
                                    <td>{{ number_format($this->details($vansale->order_code)) }}</td>
                                    <td>{{ $vansale->Customer->customer_name ?? '' }}</td>
                                    <td>{{ $vansale->User->name ?? '' }}</td>
                                    <td>{{ $vansale->User->account_type ?? '' }}</td>
                                    <td><a href="{{ URL('orders/vansaleitems/' . $vansale->order_code) }}"
                                            class="btn btn-sm"
                                            style="background-color: rgb(173, 37, 37);color:white">View</a></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
