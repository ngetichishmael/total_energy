    @if (Auth::check() && Auth::user()->account_type == 'Distributors')
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
                        <a href="{!! route('delivery.index') !!}" class="btn btn"
                            style="background-color:#1877F2; color:#ffffff;">View Sales</a>
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
