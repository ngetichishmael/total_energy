<div class="col-md-6">
    <div class="card card-inverse">
        <div class="card-body">
            <div class="card-body">
                <table id="data-table-default" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Name</th>
                            <th>Subregion</th>
                            <th>Region</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($zones as $key => $zone)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $zone->name }}</td>
                                <td>{{ $zone->Subregion->name }}</td>
                                <td>{{ $zone->Subregion->Region->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $zones->links() }}
        </div>
    </div>
</div>
