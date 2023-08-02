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
        <div class="col-md-2">
                <div class="btn-group">
                    
                    <button type="button" class="btn btn-icon btn-outline-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" wire:loading.attr="disabled" >
                        <img src="{{ asset('assets/img/excel.png') }}" alt="Export Excel" width="15" height="15">
                        Export
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" wire:click="export">Excel</a>
                        <a class="dropdown-item" wire:click="exportCSV">CSV</a>
                        <a class="dropdown-item" wire:click="exportPDF">PDF</a>
                       
                    </div>
                </div>

                
            </div>
    </div>
</div>
<div class="row">
<div class="col-md-7">
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
                    @forelse ($outlets as $key => $outlet)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $outlet->outlet_name }}</td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle show-arrow" data-toggle="dropdown" style="background-color:#1877F2; color:#ffffff;">
                            <i data-feather="eye"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('outlets.edit',$outlet->outlet_code) }}">
                                <i data-feather="edit" class="mr-50"></i>
                                <span>Edit</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('outlets.destroy',$outlet->outlet_code) }}">
                                <i data-feather='trash' class="mr-50"></i>
                                <span>Delete</span>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">No outlets found.</td>
            </tr>
        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $outlets->links() }}
        </div>
    </div>
</div>
<div class="col-md-5">
            <div class="card card-default">
                <div class="card-body">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Add Outlet</h4> -->

                        <form class="form" method="POST" action="{{ route('outlets.store') }}">
                            @method('POST')
                            @csrf
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="outlet_code">Outlet Name</label>
                                    <input type="text" id="outlet_name" class="form-control" placeholder="Outlet Name"
                                        name="outlet_name" required />
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <input type="text" id="outlet_code" class="form-control"
                                        value="{{ str::random(20) }}" name="outlet_code" hidden readonly />
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <input type="text" id="business_code" class="form-control"
                                        value="{{ Auth::user()->business_code }}" name="business_code" hidden readonly />
                                </div>
                            </div>

                            <div class="my-1 col-sm-9 offset-sm-3">
                                <button type="submit" class="mr-1 btn btn" style="background-color:#1877F2; color:#ffffff;">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>