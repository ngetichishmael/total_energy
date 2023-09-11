<!DOCTYPE html>
<html>
<head>
    <title>Targets PDF Export</title>
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
          <b>  <p>Targets Information</p> </b>
        </center>
    </div>
    <table class="table table-striped table-bordered table-responsive">
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>User Type</th>
                <th>Target</th>
                <th>Achieved</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($targets as $key => $target)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $target->name }}</td>
                    <td>{{ $target->account_type }}</td>
                    <td class="cell-fit">
                        <strong>Leads:</strong> {{ $target->leads_target }},<strong>Orders:</strong>
                        {{ $target->orders_target }},<strong>Sales:</strong>
                        {{ $target->sales_target }},<strong>Visits:</strong>
                        {{ $target->visits_target }}
                    </td>
                    <td class="cell-fit">
                        <strong>Leads:</strong>
                        {{ $target->achieved_leads_target }},<strong>Orders:</strong>
                        {{ $target->achieved_orders_target }},<strong>Sales:</strong>
                        {{ $target->achieved_sales_target }},<strong>Visits:</strong>
                        {{ $target->achieved_visits_target }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>