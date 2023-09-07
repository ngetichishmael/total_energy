<table id="data-table-default" class="table table-striped table-bordered" style="padding-left: 6%; padding-right: 5%;">
    <thead>
        <tr>
            <th width="1%">#</th>
            <th>Account Types</th>
            <th width="20%">Number of Users</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($groups as $group => $count)
            <tr>
                <td>{!! $counting++ !!}</td>
                <td>{!! $group !!}</td>
                <td>{{ $count }}</td>
                <td>
                    <div class="d-flex" style="gap:10px">
                        @if ($group == 'Admin' && Auth()->user()->account_type === 'Admin')
                            <a href="{{ route('users.admins') }}" class="btn btn btn-sm"
                                style="background-color:#1877F2; color:#ffffff;">View</a>
                        @elseif($group == 'Lube Sales Executive')
                            <a href="{{ route('LubeSalesExecutive') }}" class="btn btn btn-sm"
                                style="background-color:#1877F2; color:#ffffff;">View</a>
                        @elseif($group == 'Distributors' && Auth()->user()->account_type === 'Admin')
                            <a href="{{ route('Distributors') }}" class="btn btn btn-sm"
                                style="background-color:#1877F2; color:#ffffff;">View</a>
                        @elseif($group == 'Lube Merchandizers')
                            <a href="{{ route('lubemerchandizer') }}" class="btn btn btn-sm"
                                style="background-color:#1877F2; color:#ffffff;">View </a>
                        @elseif($group == 'Managers' && Auth()->user()->account_type === 'Admin')
                            <a href="{{ route('Managers') }}" class="btn btn btn-sm"
                                style="background-color:#1877F2; color:#ffffff;">View </a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
