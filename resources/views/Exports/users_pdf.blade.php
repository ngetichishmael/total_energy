<!DOCTYPE html>
<html>
<head>
    <title>Users PDF Export</title>
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
          <b>  <p>Users Information</p> </b>
        </center>
    </div>
    <table id="data-table-default" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>User Type</th>
                <th>Number of Users</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usercount as $key => $user)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $user->account_type }}</td>
                    <td>{{ $user->count }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</body>
</html>