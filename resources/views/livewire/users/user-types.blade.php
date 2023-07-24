<div>
    <div class="content-header row"style="padding-left:6%; padding-right:5%">
        <div class="content-header-left col-md-12 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <!-- <h2 class="content-header-title float-start mb-0">Users Roles</h2> -->
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/users-Roles">Users</a></li>
                        </ol>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('partials._messages')
    <div class="align-content-center">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="account-types-tab" data-bs-toggle="tab" href="#account-types"
                    role="tab" aria-controls="account-types" aria-selected="true">Account Types</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="regions-tab" data-bs-toggle="tab" href="#regions" role="tab"
                    aria-controls="regions" aria-selected="false">Regions</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="account-types" role="tabpanel"
                aria-labelledby="account-types-tab">
                <div class="content-header row" style="padding-left: 6%; padding-right: 5%">
                    <div class="row" style="padding-left:6%; padding-right:5%">
                        <div class="col-md-12">
                            <div class="card card-inverse">
                                <div class="card-body">
                                    <table id="data-table-default" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="1%">#</th>
                                                <th>Account Types</th>
                                                <th width="20%">Number of Users</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lists as $list)
                                                <tr>
                                                    <td>{!! $count++ !!}</td>
                                                    <td>{!! $list !!}</td>
                                                    <td>{{ $counts[$list] }}</td>
                                                    <td>
                                                        <div class="d-flex" style="gap:10px">
                                                            @if ($list == 'Admin')
                                                                <a href="{{ route('users.admins') }}"
                                                                    class="btn btn-primary btn-sm">View</a>
                                                            @elseif($list == 'Lube Sales Executive')
                                                                <a href="{{ route('LubeSalesExecutive') }}"
                                                                    class="btn btn-primary btn-sm">View</a>
                                                            @elseif($list == 'Lube Merchandizers')
                                                                <a href="{{ route('lubemerchandizer') }}"
                                                                    class="btn btn-primary btn-sm">View </a>
                                                            @elseif($list == 'Sales')
                                                                <a href="{{ route('sales') }}"
                                                                    class="btn btn-primary btn-sm">View </a>
                                                            @elseif($list == 'Distributors')
                                                                <a href="{{ route('Distributors') }}"
                                                                    class="btn btn-primary btn-sm">View </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="regions" role="tabpanel" aria-labelledby="regions-tab">
                <div class="content-header row" style="padding-left: 6%; padding-right: 5%">

                    <div class="row" style="padding-left:6%; padding-right:5%">
                        <div class="col-md-12">
                            <div class="card card-inverse">
                                <div class="card-body">
                                    <table id="data-table-default" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="1%">#</th>
                                                <th>Region</th>
                                                <th width="20%">Number of Users</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($regions as $key => $region)
                                                <tr>
                                                    <td>{!! $key + 1 !!}</td>
                                                    <td>{!! $region->region_name !!}</td>
                                                    <td>{!! $region->unique_users_count !!}</td>
                                                    <td>
                                                        <a href="{{ route('regionalUsers', [
                                                            'region_id' => $region->region_id,
                                                        ]) }}"
                                                            class="btn btn-primary btn-sm">View </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle tab switching
        document.addEventListener("DOMContentLoaded", function() {
            let tabs = new bootstrap.Tab(document.getElementById("myTab"));

            // Handle URL hash changes to switch tabs
            window.addEventListener("hashchange", function() {
                let hash = window.location.hash;
                if (hash === "#regions") {
                    tabs.show("regions-tab");
                } else {
                    tabs.show("account-types-tab");
                }
            });
        });
    </script>

</div>
