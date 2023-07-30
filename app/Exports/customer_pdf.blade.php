<!DOCTYPE html>
<html>
<head>
    <title>Customers PDF Export</title>
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
            <h1>Kenmeat</h1>
            <p>Customers Information</p>
        </center>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Number</th>
                <th width="20%">Address</th>
                <th>Zone/Region</th>
                <th>Route</th>
                <th>Created By</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td>
                        {!! $contact->customer_name !!} <br>
                        @if ($contact->approval === 'Approved')
                        {{-- Add any custom content here if needed --}}
                        @endif
                    </td>
                    <td>{!! $contact->phone_number !!}</td>
                    <td>
                        {{ $contact->address }}
                    </td>
                    <td>
                        @if ($contact->Area && $contact->Area->Subregion && $contact->Area->Subregion->Region)
                            {!! $contact->Area->Subregion->Region->name !!}
                            @if ($contact->Area->Subregion->name)
                            , <br><i>{!! $contact->Area->Subregion->name !!}</i>
                            @endif
                        @endif
                    </td>
                    <td>
                        {!! $contact->Area->name ?? '' !!}
                    </td>
                    <td>
                        {!! $contact->Creator->name ?? '' !!}
                    </td>
                    <td>
                    {!! $contact->created_at ? $contact->created_at->format('Y-m-d h:i A') : '' !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
