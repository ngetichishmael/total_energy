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

<div class="col-md-6">
    <div class="card card-inverse">
        <div class="card-body">
            <div class="card-body">
                <table id="data-table-default" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outlets as $key => $outlet)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $outlet->outlet_name }}</td>
                                <td>
                                    <div class="dropdown" >
                                        <button class="btn btn-md btn-primary dropdown-toggle mr-2" type="button" id="dropdownMenuButton" data-bs-trigger="click" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                           <i data-feather="settings"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="" type="button" class="dropdown-item btn btn-sm" style="color: #7cc7e0; font-weight: bold"><i data-feather="eye"></i>&nbsp; View</a>
                                           <a href="{{ route('outlets.edit',$outlet->outlet_code) }}" type="button" class="dropdown-item btn btn-sm" style="color: #6df16d;font-weight: bold"><i data-feather="edit"></i> &nbsp;Edit</a>
                                          <a href="{{ route('outlets.destroy',$outlet->outlet_code) }}" type="button" class="dropdown-item btn btn-sm me-2" style="color: #e5602f; font-weight: bold"><i data-feather="delete"> </i> &nbsp; Delete</a>
  
                                        </div>
                                     </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $outlets->links() }}
        </div>
    </div>
</div>
