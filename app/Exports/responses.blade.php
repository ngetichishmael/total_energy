<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th width="1%">#</th>
            <th>Customer</th>
            <th>Survey</th>
            <th>Question</th>
            <th>Answer</th>
            <th>Reason</th>
            <th>Date Created</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($responses as $count => $response)
            <tr class="odd gradeX">
                <td width="1%" class="f-s-600 text-inverse">{{ $count + 1 }}</td>
                <td>{{ $response->Customer->customer_name ?? '' }}</td>
                <td>{{ $response->Survey->description ?? '' }}</td>
                <td>{{ $response->Question->question ?? '' }}</td>
                <td>{{ $response->Answer ?? '' }}</td>
                <td>{{ $response->reason ?? '' }}</td>
                <td>{{ $response->created_at }}</td>
            </tr>
        @empty
            <tr class="odd gradeX">
                <td colspan="8"> No Survey Responses Available</td>
            </tr>
        @endforelse
    </tbody>
</table>
