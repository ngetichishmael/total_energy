<div class="col-md-6">
    <div class="card card-inverse">
        <div class="card-body">
            <div class="card-body">
                <table id="data-table-default" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outlets as $key => $outlet)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $outlet->outlet_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $outlets->links() }}
        </div>
    </div>
</div>
