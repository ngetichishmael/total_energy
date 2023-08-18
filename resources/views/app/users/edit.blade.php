@extends('layouts.app1')
{{-- page header --}}
@section('title', 'Edit User')



{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->

    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-12">
            <div class="row breadcrumbs-top" style="padding-left:5%; padding-right:5%">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start">Users </h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Users</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="padding-left:5%; padding-right:5%">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST"
                        action="{{ route('user.update', [
                            'id' => $user_code,
                        ]) }}"
                        style="gap: 20px;">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-2 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">User Name</label>
                                                    <input type="text" id="first-name-column" class="form-control"
                                                        placeholder="User Name" value="{{ $edit->name }}"
                                                        name="name" />
                                                </div>
                                            </div>
                                            <div class="mb-2 col-md-6 col-12 ">
                                                <div class="form-group">
                                                    <label for="last-name-column">Last Name</label>
                                                    <input type="email" id="last-name-column" class="form-control"
                                                        value="{{ $edit->email }}" placeholder="Email" name="email" />
                                                </div>
                                            </div>
                                            <div class="mb-2 col-md-6 col-12 ">
                                                <div class="form-group">
                                                    <label for="city-column">Phone Number</label>
                                                    <input type="tel" id="city-column" class="form-control"
                                                        pattern="[0789][0-9]{9}" value="{{ $edit->phone_number }}"
                                                        name="phone_number" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="city-column">Update Password</label>
                                                    <input type="text" id="city-column" class="form-control"
                                                        placeholder="Password" name="password" />
                                                </div>
                                            </div>
                                            <div class="mb-2 col-md-6 col-12 ">
                                                <div class="form-group">
                                                    <label for="select-country">Current Type:
                                                        {{ $edit->account_type }}</label>
                                                    <select class="form-control select2" id="select-country"
                                                        name="account_type">
                                                        <option value="">Select Type</option>
                                                        <option value="Admin">Administator</option>
                                                        <option value="Distributors">Distributors</option>
                                                        <option value="Managers">Manager</option>
                                                        <option value="Lube Sales Executive">Lube Sales Executive</option>
                                                        <option value="Lube Merchandizers">Lube Merchandizers</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="select-country">Zone</label>
                                                    <select class="form-control select2" id="select-country" name="route[]"
                                                        required multiple>
                                                        <option value="">Zone</option>
                                                        <option value="0"
                                                            @if ($edit->route_code == 0) selected @endif>General
                                                        </option>
                                                        @foreach ($routes as $value)
                                                            <option value="{{ $value->id }}"
                                                                @if ($value->id == $edit->route_code) selected @endif>
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-2 col-md-6 col-12 ">
                                                <div class="form-group">
                                                    <label for="select-country">Current Status:
                                                        {{ $edit->status }}</label>
                                                    <select class="form-control" id="select-action" name="status">
                                                        <option value="Active"
                                                            @if ($edit->route_code == 'Active') selected @endif>
                                                            Active</option>
                                                        <option value="Suspend"
                                                            @if ($edit->route_code == 'Suspended') selected @endif>
                                                            Suspended</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <!-- Account Tab starts -->
                            <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                                <form class="form-validate">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mt-1 border rounded table-responsive">
                                                <h6 class="py-1 mx-1 mb-0 font-medium-2">
                                                    <i data-feather="lock" class="font-medium-3 mr-25"></i>
                                                    <span class="align-middle">Permission Out Side Customer Shop</span>
                                                </h6>
                                                <table class="table table-striped table-borderless">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Module</th>
                                                            <th>Permission</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Van Sales</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="admin-read" name="van_sales"
                                                                        @if ($permissions->van_sales === 'YES') checked @endif />
                                                                    <label class="custom-control-label"
                                                                        for="admin-read"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>New Sales</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="staff-read" name="new_sales"
                                                                        @if ($permissions->new_sales === 'YES') checked @endif />
                                                                    <label class="custom-control-label"
                                                                        for="staff-read"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Deliveries</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="author-read" name="deliveries"
                                                                        @if ($permissions->deliveries === 'YES') checked @endif />
                                                                    <label class="custom-control-label"
                                                                        for="author-read"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Schedule Visits </td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="contributor-read" name="schedule_visits"
                                                                        @if ($permissions->schedule_visits === 'YES') checked @endif />
                                                                    <label class="custom-control-label"
                                                                        for="contributor-read"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Merchanizing</td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="user-read" name="merchanizing"
                                                                        @if ($permissions->merchanizing === 'YES') checked @endif />
                                                                    <label class="custom-control-label"
                                                                        for="user-read"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="mt-2 col-12 d-flex flex-sm-row flex-column justify-content-center text-center" style="gap: 20px;">
                                            <button type="submit" class="mb-1 mr-0 btn btn-primary mb-sm-0 mr-sm-1">Update</button>
                                            <a href="{{ route('users.list') }}" type="reset" class="btn btn-outline-secondary">Cancel</a>
                                        </div>

                                    </div>
                                </form>
                                <!-- users edit account form ends -->
                            </div>
                            <!-- Account Tab ends -->
                        </div>
                        <!-- Basic Floating Label Form section end -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- page scripts --}}
@section('script')
    <script>
        $(document).ready(function() {
            $('.js-select2').select2();
        });
    </script>
@endsection
