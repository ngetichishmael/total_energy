<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer Comments PDF Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size:16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            font-size:10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
        }
        .no-data {
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="logo">
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('app-assets/images/small_logo.png'))) }}" alt="Logo" width="150" height="80">
    </div>
    <h1>Customer Comments List</h1>
    @if ($comments->isEmpty())
        <p class="no-data">No comments found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $key => $comment)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $comment->Customer->customer_name ?? ''}}</td>
                        <td>{{ $comment->User->name ?? ''}}</td>
                        <td>{{ $comment->date ?? ''}}</td>
                        <td>{{ $comment->comment ?? ''}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
