<!DOCTYPE html>
<html>
<head>
    <title>PreOrders PDF Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        td {
        font-size: 10px; /* Adjust the font size as needed */
        }
        
        /* Add custom styling for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            font-size: 11px; /* Adjust the font size as needed */
            background-color: #f2f2f2;
        }

        /* Add custom styling for the header */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Add any other custom CSS styles here */

    </style>
</head>
<body>
    <div class="header">
        <center>
        <div class="logo">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('app-assets/images/small_logo.png'))) }}" alt="Logo" width="150" height="80">
                </div>
          <b>  <p>PreOrders Information</p> </b>
        </center>
    </div>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Added By</th>
                <th>Region</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_code }}</td>
                    <td>{{ $order->Customer->customer_name ?? '' }}</td>
                    <td>{{ $order->User->name ?? '' }}</td>
                    <td class="cell-fit">
                        {{ $order->Customer->Area->Subregion->name ?? '' }},
                        {{ $order->User->Region->name ?? '' }}
                    </td>
                    <td>{{ $order->order_status ?? '' }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>