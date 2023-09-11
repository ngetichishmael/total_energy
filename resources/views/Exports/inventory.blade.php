<div>
    <table id="data-table-default" class="table table-striped table-bordered">
        <thead>
           <tr>
              <th>#</th>
              <th>Warehouse Name</th>
              
           </tr>
        </thead>
        <tbody>
         @foreach ($warehouses as $warehouse)
         <tr>
            <td>{{ $count++ }}</td>
            <td>{{ $warehouse->name }}</td>

        </tr>
         @endforeach
           
        </tbody>
     </table>

    <div class="mt-4">
        <button wire:click="export" class="btn btn-primary">Export CSV</button>
    </div>
</div>