<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" href="style.css">
      <title>Receipt</title>
      <style>
         * {
            font-size: 12px;
            font-family: 'Times New Roman';
         }

         td,
         th,
         tr,
         table {
            border-top: 1px solid black;
            border-collapse: collapse;
         }

         td.description,
         th.description {
            width: 75px;
            max-width: 75px;
         }

         td.quantity,
         th.quantity {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
         }

         td.price,
         th.price {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
         }

         .centered {
            text-align: center;
            align-content: center;
         }

         .ticket {
            width: 250px;
            max-width: 250px;
         }

         img {
            max-width: inherit;
            width: inherit;
         }

         @media print {
            .hidden-print,
            .hidden-print * {
               display: none !important;
            }
         }
      </style>
   </head>
   <body>
      <div class="ticket">
         {{-- <img src="./logo.png" alt="Logo"> --}}
         <center>
            <p class="centered">RECEIPT
            <br><b>Order Number</b> : {!! $order->order_id !!}
            <br><b>Order Date</b> : {!! date('F jS, Y', strtotime($order->created_at)) !!}</p>
         </center>
         <table>
            <thead>
               <tr>
                  <th class="quantity">Q.</th>
                  <th class="description">Description</th>
                  <th class="price">ksh</th>
               </tr>
            </thead>
            <tbody>
               @foreach($orderItems as $item)
                  <tr>
                     <td class="quantity">{!! $item->quantity !!} x {!! number_format($item->selling_price) !!}</td>
                     <td class="description">{!! $item->product_name !!}</td>
                     <td class="price">ksh {!! number_format($item->total_amount) !!}</td>
                  </tr>
               @endforeach
               {{-- <tr>
                  <td class="quantity"></td>
                  <td class="description">SUB TOTAL</td>
                  <td class="price">ksh {!! number_format($order->price_total) !!}</td>
               </tr>
               <tr>
                  <td class="quantity"></td>
                  <td class="description">TAX ({!! $order->tax_rate !!}%)</td>
                  <td class="price">ksh {!! number_format($order->tax) !!}</td>
               </tr> --}}
               <tr>
                  <td class="quantity"></td>
                  <td class="description">TOTAL</td>
                  <td class="price">ksh {!! number_format($order->price_total) !!}</td>
               </tr>
            </tbody>
         </table>
         <p class="centered">Thanks for your purchase!</p>
      </div>
   </body>
</html>
