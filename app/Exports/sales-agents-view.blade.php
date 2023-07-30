<table>
    <caption>Visits for {{ $username }}</caption>
    <thead>
        <tr>
            <th>#</th>
            <th>Sales Associate</th>
            <th>Customer Name</th>
            <th>Start Time</th>
            <th>Stop Time</th>
            <th>Duration</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($visits as $count => $visit)
        <tr>
            <td>{{ $count + 1 }}</td>
            <td>{{ $visit->name }}</td>
            <td>{{ $visit->customer_name }}</td>
            <td>{{ $visit->start_time }}</td>
            <td>{{ $visit->stop_time }}</td>
          
            <td>{{ $visit->formatted_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
