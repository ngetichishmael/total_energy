<div class="row">
    <div class="col-md-3">
        <label for="validationTooltip01">Start Date</label>
        <input wire:model="start" name="start" type="date" class="form-control" id="validationTooltip01"
            placeholder="YYYY-MM-DD HH:MM" required />
    </div>
    <div class="col-md-3">
        <label for="validationTooltip01">End Date</label>
        <input wire:model="end" name="startDate" type="date" class="form-control" id="validationTooltip01"
            placeholder="YYYY-MM-DD HH:MM" required />
    </div>
    <div class="col-md-3">
        <label for="">User Category</label>
        <select wire:model="" class="form-control" disabled>`
            <option value="" selected>select</option>
            <option value=""></option>

        </select>
    </div>
    <div class="col-md-3">
        <button type="button" class="btn btn-icon btn-outline-success" wire:click="export" wire:loading.attr="disabled"
            data-toggle="tooltip" data-placement="top" title="Export Excel">
            <img src="{{ asset('assets/img/excel.png') }}"alt="Export Excel" width="20" height="20"
                data-toggle="tooltip" data-placement="top" title="Export Excel">Export to Excel
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label for="">Status</label>
        <select wire:model="" class="form-control">`
            <option value="" selected>select</option>
            <option value=""></option>

        </select>
    </div>
</div>
<br>
<div class="row">
    @include('partials.stickymenu')

    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>User Type</th>
                                <th>Target</th>
                                <th>Achieved</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($targets as $key => $target)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $target->name }}</td>
                                    <td>{{ $target->account_type }}</td>
                                    <td class="cell-fit">
                                        <strong>Leads:</strong> {{ $target->leads_target }},<strong>Orders:</strong>
                                        {{ $target->orders_target }},<strong>Sales:</strong>
                                        {{ $target->sales_target }},<strong>Visits:</strong>
                                        {{ $target->visits_target }}
                                    </td>
                                    <td class="cell-fit">
                                        <strong>Leads:</strong>
                                        {{ $target->achieved_leads_target }},<strong>Orders:</strong>
                                        {{ $target->achieved_orders_target }},<strong>Sales:</strong>
                                        {{ $target->achieved_sales_target }},<strong>Visits:</strong>
                                        {{ $target->achieved_visits_target }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-1">
                        {{ $targets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
