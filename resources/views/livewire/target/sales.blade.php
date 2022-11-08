<div>
    <div class="row mb-2">

        <div class="col-md-9">
            <label for="">Search</label>
            <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Search ...">
            <!-- Button trigger modal -->
            <div class="mt-1">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    New Target
                </button>
            </div>
        </div>
        <div class="col-md-3">
            <label for="">Items Per</label>
            <select wire:model="perPage" class="form-control">`
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>resese@mailinator.com</td>
                        <td>400</td>
                        <td>0</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sales Target</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" wire:submit.prevent="newTarget()">
                    <div class="row">
                        <!-- Custom Select -->
                        <div class="form-group">
                           <label for="selectDefaultS">Sales Person</label>
                           <select class="form-control mb-1" id="selectDefaultS" wire:model.defer="salesperson" required>
                             <option selected value="">Select Salesperson</option>
                             @foreach ($users as $user )

                             <option value="{{ $user->code }}">{{ $user->name }}</option>
                             @endforeach
                           </select>
                         </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="contact-info-vertical">Target</label>
                                <input wire:model.defer="target" type="number" id="contact-info-vertical" class="form-control" name="contact"
                                    placeholder="Mobile" required/>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-primary mr-1">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
