<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Outlet PDF Export</title>
    <!-- Add your custom CSS styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        /* Customize the logo styles */
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            width: 150px; /* Adjust the width of the logo as needed */
        }
        /* Customize the subheading styles */
        .subheading {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        /* Customize the table styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="logo">
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('app-assets/images/logo.png'))) }}" alt="Logo" width="150" height="80">
    </div>
    <div class="subheading">Outlet List</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <!-- Add other table headers if needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($outlets as $key => $outlet)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $outlet->outlet_name }}</td>
                    <!-- Add other table data fields if needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
