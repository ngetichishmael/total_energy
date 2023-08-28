<div>
   <div class="justify-content-end align-items-center mx-50 mb-2" > <a type="button" href="{{route('dashboard.allocated.users')}}" class="btn-success btn-lg rounded-2">Current Allocations</a></div>
    <div class="col-xl-12 col-md-12 col-12">

        <div class="card">
            <div class="pt-0 pb-2 d-flex justify-content-end align-items-center mx-50 row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="validationTooltip01" style="padding:10px">Start Date</label>
                        <input wire:model="start" name="startDate" type="date" class="form-control"
                            id="validationTooltip01" placeholder="YYYY-MM-DD HH:MM" required />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="validationTooltip01" style="padding:10px">End Date</label>
                        <input wire:model="end" name="startDate" type="date" class="form-control"
                            id="validationTooltip01" placeholder="YYYY-MM-DD HH:MM" required />
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if(Auth::check() && Auth::user()->account_type == 'Distributors')
    <div class="row match-height">
        <!-- Medal Card -->
        <div class="col-xl-4 col-md-6 col-12">
            <div class="card card-congratulation-medal">
                <div class="card-body">
                    <h5>Welcome once again 🎉 </h5>
                    <p class="card-text font-small-3">Feel free to explore around</p>
                    <h3 class="mt-2 mb-75 pt-50">
                        <?php
                        // Calculate the sum total
                        $sumTotal = $Cash + $Mpesa + $Cheque + $total;
                        ?>

                        <a href="javascript:void(0);"> Ksh. {{ number_format($sumTotal) }} </a>
                    </h3>
                    <a href="{!! route('delivery.index') !!}" class="btn btn"  style="background-color:#1877F2; color:#ffffff;" >View Sales</a>
                    <img src="{{ asset('images/illustration/badge.svg') }}" class="congratulation-medal"
                        alt="Medal Pic" />
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-md-6 col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h4 class="card-title"> Revenue Collected</h4>
                    <div class="d-flex align-items-center">

                    </div>
                </div>
                <div class="card-body statistics-body">
                    <div class="row">

                        <div class="mb-2 col-xl-3 col-sm-6 col-12 mb-xl-0">
                            <div class="media">

                                <a href="#vansalesSection" class="d-flex align-items-center">
                                    <div class="avatar bg-light-info">
                                        <div class="avatar-content">
                                            <i data-feather="trending-up" class="avatar-icon"></i>
                                        </div>
                                    </div> &nbsp;&nbsp;
                                    <div class="pl-3 my-auto ml-3 media-body">
                                        <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                            &nbsp; {{ number_format($Cash) }}</h4>
                                        <p class="mb-0 card-text font-small-3 font-medium-1"
                                            style="color: rgba(71,75,79,0.76)"> Cash </p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="mb-2 col-xl-3 col-sm-6 col-12 mb-xl-0">
                            <div class="media">

                                <a href="#vansalesSection" class="d-flex align-items-center">
                                    <div class="avatar bg-light-success">
                                        <div class="avatar-content">
                                            <i data-feather="shield" class="avatar-icon"></i>
                                        </div>
                                    </div> &nbsp;&nbsp;
                                    <div class="pl-3 my-auto ml-3 media-body">
                                        <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                            &nbsp; {{ number_format($Mpesa) }}</h4>
                                        <p class="mb-0 card-text font-small-3 font-medium-1"
                                            style="color: rgba(71,75,79,0.76)"> Mpesa </p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="mb-2 col-xl-3 col-sm-6 col-12 mb-sm-0">
                            <div class="media">


                                <a href="#vansalesSection" class="d-flex align-items-center">
                                    <div class="avatar bg-light-danger">
                                        <div class="avatar-content">
                                            <i data-feather="box" class="avatar-icon"></i>
                                        </div>
                                    </div> &nbsp;&nbsp;
                                    <div class="pl-3 my-auto ml-3 media-body">
                                        <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                            &nbsp; {{ number_format($Cheque) }}</h4>
                                        <p class="mb-0 card-text font-small-3 font-medium-1"
                                            style="color: rgba(71,75,79,0.76)"> Cheque </p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="media">


                                <a href="#vansalesSection" class="d-flex align-items-center">
                                    <div class="avatar bg-light-warning">
                                        <div class="avatar-content">
                                            <i data-feather="dollar-sign" class="avatar-icon"></i>
                                        </div>
                                    </div> &nbsp;&nbsp;
                                    <div class="pl-3 my-auto ml-3 media-body">
                                        <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                            &nbsp; {{ number_format($total) }}</h4>
                                        <p class="mb-0 card-text font-small-3 font-medium-1"
                                            style="color: rgba(71,75,79,0.76)"> Bank</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Statistics Card -->
    </div>

    @endif

    <div class="col-xl-12 col-md-12 col-12">
        <div class="card card-statistics">
            <div class="card-header">
                <h4 class="card-title">Top Product Value</h4>
                <div class="d-flex align-items-center">
                    <p class="mb-0 card-text font-small-2 mr-25">Default Shows Monthly Report</p>
                </div>
            </div>
            <div class="card">

                <div class="mt-0 card-body statistics-body">
                    <div class="row">
                    @php $avatarIcons = ['inventory', ' check_circle', 'inventory', 'order_approve', ' check_circle', 'order_approve']; @endphp

@foreach($topproducts as $index => $product)
    @php $avatarIndex = $index % count($avatarIcons); @endphp

    <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
        <a href="#salesSection" class="d-flex align-items-center">
            <div class="avatar bg-light-warning">
                <div class="avatar-content">
                    <span class="material-symbols-outlined">{{ $avatarIcons[$avatarIndex] }}</span>
                </div>
            </div> &nbsp;&nbsp;
            <div class="pl-3 my-auto ml-3 media-body">
                <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                    &nbsp; {{ $product->total_quantity }} </h4>
                <p class="mb-0 card-text font-small-3 font-medium-1" style="color: rgba(71,75,79,0.76)">
                    {{ Str::limit($product->product_name, 15) }} ({{ $product->sku_code }})
                </p>
            </div>
        </a>
    </div>
@endforeach


                    </div>
                </div>
            </div>
        </div>


    <div class="col-xl-12 col-md-12 col-12">
        <div class="card card-statistics">
            <div class="card-header">
                <h4 class="card-title">Statistics</h4>
                <div class="d-flex align-items-center">
                    <p class="mb-0 card-text font-small-2 mr-25">Default Shows Monthly Report</p>
                </div>
            </div>
            <div class="card">

                <div class="mt-0 card-body statistics-body">
                    <div class="row">
                        <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                            <a href="#salesSection" class="d-flex align-items-center">
                                <div class="avatar bg-light-warning">
                                    <div class="avatar-content">
                                        <span class="material-symbols-outlined">inventory</span>
                                    </div>
                                </div> &nbsp;&nbsp;
                                <div class="pl-3 my-auto ml-3 media-body">
                                    <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                        &nbsp;{{ number_format($vansales) }}</h4>
                                    <p class="mb-0 card-text font-small-3 font-medium-1"
                                        style="color: rgba(71,75,79,0.76)">Van Sales</p>
                                </div>
                            </a>
                        </div>

                        <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                            <a href="#salesSection" class="d-flex align-items-center">
                                <div class="avatar bg-light-primary">
                                    <div class="avatar-content">
                                        <span class="material-symbols-outlined">shopping_cart</span>
                                    </div>
                                </div> &nbsp;&nbsp;
                                <div class="pl-3 my-auto ml-3 media-body">
                                    <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                        {{ number_format($preorder) }}</h4>
                                    <p class="mb-0 card-text font-small-3 font-medium-1"
                                        style="color: rgba(71,75,79,0.76)">Pre-Orders</p>
                                </div>
                            </a>
                        </div>
                        <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                            <a href="#buyingCustomersSection" class="d-flex align-items-center">
                                <div class="avatar bg-light-success">
                                    <div class="avatar-content">
                                        <span class="material-symbols-outlined"> check_circle </span>
                                    </div>
                                </div> &nbsp;&nbsp;
                                <div class="pl-3 my-auto ml-3 media-body">
                                    <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                        {{ number_format($customersCount) }}</h4>
                                    <p class="mb-0 card-text font-small-3 font-medium-1"
                                        style="color: rgba(71,75,79,0.76)">Customers</p>
                                </div>
                            </a>
                        </div>
                        <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                            <a href="#distributorsOrders" class="d-flex align-items-center">
                                <div class="avatar bg-light-info">
                                    <div class="avatar-content">
                                        <span class="material-symbols-outlined">order_approve</span>
                                    </div>
                                </div> &nbsp;&nbsp;
                                <div class="pl-3 my-auto ml-3 media-body">
                                    <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                        {{ number_format($strike) }} </h4>
                                    <p class="mb-0 card-text font-small-3 font-medium-1"
                                        style="color: rgba(71,75,79,0.76)"> Visits</p>
                                </div>
                            </a>
                        </div>

                        <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                            <a href="#orderFulfillmentSection" class="d-flex align-items-center">
                                <div class="avatar bg-light-primary">
                                    <div class="avatar-content">
                                        <span class="material-symbols-outlined">local_shipping</span>
                                    </div>
                                </div> &nbsp;&nbsp;
                                <div class="pl-3 my-auto ml-3 media-body">
                                    <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                        {{ number_format($deliveryCount) }}</h4>
                                    <p class="mb-0 card-text font-small-3 font-medium-1"
                                        style="color: rgba(71,75,79,0.76)">Deliveries</p>
                                </div>
                            </a>
                        </div>
                        <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                            <a href="#systemUsers" class="d-flex align-items-center">
                                <div class="avatar bg-light-success">
                                    <div class="avatar-content">
                                        <span class="material-symbols-outlined">people</span>
                                    </div>
                                </div> &nbsp;&nbsp;
                                <div class="pl-3 my-auto ml-3 media-body">
                                    <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                        {{ number_format($activeUser) }} </h4>
                                    <p class="mb-0 card-text font-small-3 font-medium-1"
                                        style="color: rgba(71,75,79,0.76)">Users</p>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row match-height">
            <div class="col-lg-8 col-12">
                <div class="card card-company-table">
                    <div class="p-0 card-body">
                        <div class="table-responsive">
                            <div>
                                @livewire('dashboard.line-chart')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-developer-meetup">
                    <div class="text-center meetup-img-wrapper rounded-top">
                        <img src="{{ asset('app-assets/images/illustration/marketing.svg') }}" alt="Meeting Pic"
                            height="170" />
                    </div>
                    <div class="card-body">
                        <div class="meetup-header d-flex align-items-center">
                            <div class="meetup-day">
                                <h6 class="mb-0">{{ date_format(now(), 'M') }}</h6>
                                <h3 class="mb-0">{{ date_format(now(), 'd') }}</h3>
                            </div>
                            <div class="my-auto">
                                <h4 class="card-title mb-25">Total Energies</h4>
                                <p class="mb-0 card-text">Transforming Ourselves to Reinvent Energy</p>
                            </div>
                        </div>
                        <div class="media" style="background: white">
                            <div class="mr-1 rounded avatar d-flex align-items-center" style="background: white">
                                <div class="avatar-content" style="background: white">
                                    <i data-feather="calendar" class="avatar-icon font-medium-3"
                                        style="color: #4883ee;"></i>
                                </div>
                                &nbsp;&nbsp;&nbsp;
                                <div class="pl-3" style="background: white">
                                    <h6 class="mb-0" style="color: gray;">{{ date_format(now(), 'D, F, Y') }}</h6>
                                    <small style="color: darkgray;">8:AM to 5:PM</small>
                                </div>
                            </div>
                        </div>
                        <div class="media mt-2" style="background: white">
                            <div class="mr-1 rounded avatar align-items-center" style="background: white">
                                <div class="avatar-content">
                                    <i data-feather="map-pin" class="avatar-icon font-medium-3"
                                        style="color: #4883ee;"></i>
                                </div>
                                &nbsp;&nbsp;&nbsp;
                                <div class="media-body pl-3" style="background: white;">
                                    <h6 class="mb-0" style="background: white;"> </h6>
                                    <small style="background: white; color: darkgrey">Nairobi, Kenya</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row match-height">
            <div class="col-lg-12 col-12">
                <div class="card card-company-table">
                    <div class="p-0 card-body">
                        <div class="table-responsive">
                            <div>
                                @livewire('individual.leads')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('livewire.dashboard.table')

    </div>
    <br />
</div>
