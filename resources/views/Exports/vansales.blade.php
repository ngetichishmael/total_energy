<div>
    <table id="data-table-default" class="table table-striped table-bordered">
        <thead>
           <tr>
              <th>#</th>
              <th>Order ID</th>
              <th>Customer Name</th>
              <th>User Name</th>
              <th>User Type</th>
            
           </tr>
        </thead>
        <tbody>
         @foreach ($vansales as $key => $vansale)
         <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $vansale->order_code }}</td>
            <td>{{ $vansale->Customer->customer_name??'' }}</td>
            <td>{{ $vansale->User->name??'' }}</td>
            <td>{{ $vansale->User->account_type??'' }}</td>

        </tr>
         @endforeach
           
        </tbody>
     </table>

    <div class="mt-4">
        <button wire:click="export" class="btn btn-primary">Export CSV</button>
    </div>
</div>