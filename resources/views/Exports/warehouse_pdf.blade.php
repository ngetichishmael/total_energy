<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add any necessary styles specific for the PDF here */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            font-size: 10px;
        }

        /* Customize the logo style */
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Customize the subheading style */
        .subheading {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
        }

        /* Customize the table style */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Customize the badge style */
        .badge {
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-success {
            background-color: #00b050;
            color: #fff;
        }

        .badge-warning {
            background-color: #ffc000;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="logo">
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('app-assets/images/logo.png'))) }}" alt="Logo" width="150" height="80">
    </div>
    <div class="subheading">
        Warehouses
    </div>
    <div>
        @isset($warehouses)
        <table>
            <thead>
                <tr>
                    <th width="1%">#</th>
                    <th >Name</th>
                    <th>Region</th>
                    <th>Sub Region</th>
                    <th>Products Count</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($warehouses as $count => $warehouse)
                <tr>
                    <td>{{ $count + 1 }}</td>
                    <td>{{ $warehouse->name ?? '' }}</td>
                    <td>{{ $warehouse->region->name ?? '' }}</td>
                    <td>{{ $warehouse->subregion->name ?? '' }}</td>
                    <td>{{ $warehouse->product_information_count ?? '' }}</td>
                    <td>
                        <span class="badge {{ $warehouse->status === 'Active' ? 'badge-success' : 'badge-warning' }}">
                            {{ $warehouse->status === 'Active' ? 'Active' : 'Disabled' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">No warehouses found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @else
        <p>No data available for PDF export.</p>
        @endisset
    </div>
</body>
</html>
