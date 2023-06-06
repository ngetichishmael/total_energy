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
