<div>
<div class="card">
    <h5 class="card-header"></h5>
    <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
        <div class="col-md-4 user_role">
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
        <div class="col-md-2 d-flex justify-content-end">
   

            <div class="demo-inline-spacing">
           
            <button type="button" class="btn btn-icon btn-outline-success" wire:click="export"
                wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
                <img src="{{ asset('assets/img/excel.png') }}"alt="Export Excel" width="25" height="15"
                    data-toggle="tooltip" data-placement="top" title="Export Excel">Export
            </button>
          </div>


        </div>
    </div>
</div>

<div class="card card-default">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <th width="1%">#</th>
                    <th>Customer Name</th>
                    <th>Sales Agent</th>
                    <th>Date</th>
                    <th>Comment</th>
                </thead>
                <tbody>
                    @forelse ($comments as $count => $comment)
                        <tr>
                            <td>{{ $count + 1 }}</td>
                            <td>{{ $comment->Customer->customer_name }}</td>
                            <td>{{ $comment->User->name }}</td>
                            <td>{{ $comment->date }}</td>
                            <td>{{ $comment->comment }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No comment found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-1">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</div>