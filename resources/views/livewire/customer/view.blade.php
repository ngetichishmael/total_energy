<div class="row">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <!-- User Card -->
        <div class="card mb-4">
            <div class="card-body">
            <div class="user-avatar-section d-flex align-items-center justify-content-center flex-column">
                 <!-- User Profile image with name -->
                <div class="header-profile-sidebar text-center">
                    <div class="avatar box-shadow-1 avatar-border avatar-xl">
                        <img src="{{ asset('images/no-image.png') }}" alt="user_avatar" height="70" width="70" />
                        <span class="avatar-status-online avatar-status-lg"></span>
                    </div>
                    <br><br>
                    <h4 class="chat-user-name">{{ Str::upper($customer->customer_name??'') }}</h4>
                    <span class="user-post">E-wallet : <b>{{ number_format($customer->wallet?->amount ?? 0, 2) }}</b></span>
                </div>
                <!--/ User Profile image with name -->
            </div>
<br>
                <header class="user-profile-header" style="padding-left:10%;">
                    <div class="user-profile-sidebar-area">
                        <!-- About User -->
                        <h6 class="section-label mb-1">About</h6>
                        <p>Onboarded by {{ $customer->Creator?->name }} om {{ $customer->created_at->format('d M, Y') }}</p>
                        <!-- About User -->

                        <!-- User's personal information -->
                        <div class="personal-info">
                            <h6 class="section-label mb-1 mt-3">Personal Information</h6>
                            <ul class="list-unstyled">
                                <li class="mb-1">
                                    <i data-feather="mail" class="font-medium-2 mr-50"></i>
                                    <span class="align-middle">{{ $customer->email }}</span>
                                </li>
                                <li class="mb-1">
                                    <i data-feather="phone-call" class="font-medium-2 mr-50"></i>
                                    <span class="align-middle">{{ $customer->phone_number }}</span>
                                </li>
                                <li class="mb-1">
                                    <i data-feather="map-pin" class="font-medium-2 mr-50"></i>
                                    <span class="align-middle">{{ $customer->address }}</span>
                                </li>
                                <li class="mb-1">
                                    <i data-feather="arrow-right-circle" class="font-medium-2 mr-50"></i>
                                    <span class="align-middle">{{ $customer->customer_group }}</span>
                                </li>
                                <li>
                                    <i data-feather="clock" class="font-medium-2 mr-50"></i>
                                    <span class="align-middle">Mon - Fri 7AM - 8PM</span>
                                </li>
                            </ul>
                        </div>
                        <!--/ User's personal information -->

                        <!-- User's Links -->
                        <div class="more-options">
                            <h6 class="section-label mb-1 mt-3">Others</h6>
                            <ul class="list-unstyled">
                                <li class="cursor-pointer mb-1">
                                    <i data-feather="tags" class="font-medium-2 mr-50"></i>
                                    <span class="align-middle"></span>
                                </li>
                                <li class="cursor-pointer mb-1">
                                    <i data-feather="star" class="font-medium-2 mr-50"></i>
                                    <span class="align-middle"></span>
                                </li>
                                <li class="cursor-pointer mb-1">
                                    <i data-feather="image" class="font-medium-2 mr-50"></i>
                                    <span class="align-middle"></span>
                                </li>
                                <li class="cursor-pointer mb-1">
                                    <i data-feather="trash" class="font-medium-2 mr-50"></i>
                                    <span class="align-middle"></span>
                                </li>
                                <li class="cursor-pointer">
                                    <i data-feather="slash" class="font-medium-2 mr-50"></i>
                                    <span class="align-middle"></span>
                                </li>
                            </ul>
                        </div>
                        <!--/ User Links -->
                    </div>
                </header>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
    <!-- User Pills -->
    <ul class="nav nav-pills flex-column flex-md-row mb-4">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#visits-tab">
                <i class="ti ti-user-check ti-xs me-1"></i>Visits
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#orders-tab">
                <i class="ti ti-lock ti-xs me-1"></i>Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#payments-tab">
                <i class="ti ti-currency-dollar ti-xs me-1"></i>Payments
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="visits-tab">
            <!-- Visits Timeline -->
            @livewire('customer.visit', [
                'customer_id' => $customer_id,
            ])
            <!-- /Visits Timeline -->
        </div>
        <div class="tab-pane fade" id="orders-tab">
            <!-- Orders Timeline -->
            @livewire('customer.order', [
                'customer_id' => $customer_id,
            ])
            <!-- /Orders Timeline -->
        </div>
        <div class="tab-pane fade" id="payments-tab">
            <!-- Payments Timeline -->
            @livewire('customer.payment', [
                'customer_id' => $customer_id,
            ])
            <!-- /Payments Timeline -->
        </div>
    </div>
</div>

</div>
