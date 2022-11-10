<div class="card card-default">
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="1%">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Date addded</th>
                    <th width="18%">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr {{-- class="success" --}}>
                        <td>{!! $count++ !!}</td>
                        <td>{!! $supplier->supplier_name !!}</td>
                        <td>{!! $supplier->supplier_email !!}</td>
                        <td>{!! $supplier->phone_number !!}</td>
                        <td>{!! date('d F, Y', strtotime($supplier->created_at)) !!}</td>
                        <td>
                            <div class="d-flex" style="gap: 20px">
                                <a href="{{ route('supplier.edit', $supplier->supplierID) }}"
                                    class="btn btn-sm btn-primary">
                                    <span>Edit</span>
                                </a>
                                <a href="{!! route('supplier.delete', $supplier->supplierID) !!}" class="btn btn-sm btn-danger delete">
                                 <span>Delete</span>
                              </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-1">{!! $suppliers->links() !!}</div>
    </div>
</div>