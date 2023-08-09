   <!-- Project table -->
   <div class="card mb-4">
       <h5 class="card-header">Customer orders</h5>
       <div class="table-responsive mb-3">
           <table class="table datatable-project border-top">
               <thead>
                   <tr>
                       <th>Order Code</th>
                       <th>Total Price</th>
                       <th>Payment Status</th>
                       <th>Order Status</th>
                       <th>Date</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach ($orders as $order)
                       <tr>
                           <td>{{ $order->order_code }}</td>
                           <td>{{ $order->price_total }}</td>
                           <td>{{ $order->payment_status }}</td>
                           <td>{{ $order->order_status }}</td>
                           <td>{{ $order->created_at->format('Y-m-d') }}</td>
                       </tr>
                   @endforeach
           </table>
       </div>
   </div>
   <!-- /Project table -->
