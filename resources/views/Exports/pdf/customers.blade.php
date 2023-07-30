<!DOCTYPE html>
<html>
<head>
    <title>Customers Print Export</title>
    <style>
        /* Define your CSS styles for printing here */
        /* For example: */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Customers List (Print Export)</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <!-- Add more table headers here based on your data -->
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->name }}</td>
                    <!-- Add more table data here based on your data -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
