<div class="col-md-6">
    <div class="card card-inverse">
        <div class="card-body">
            <div class="card-body">
                <table id="data-table-default" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Name</th>
                            <th>Area</th>
                            <th>Sub Region</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subareas as $key => $subarea)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $subarea->name }}</td>
                                <td>{{ $subarea->Area->name }}</td>
                                <td>{{ $subarea->Area->Subregion->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $subareas->links() }}
        </div>
    </div>
</div>
