@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/plugins/charts/chart-apex.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/pages/dashboard-ecommerce.min.css') !!}">
@endsection
@section('content')
    <!-- Statistics Card -->
    <div class="col-xl-12 col-md-6 col-12">
        <div class="card card-statistics">
            <div class="card-header">
                <h4 class="card-title">Statistics</h4>
                <div class="d-flex align-items-center">
                    <p class="card-text font-small-2 mr-25 mb-0">{{ now() }}</p>
                </div>
            </div>
            <div class="card-body statistics-body">
                <div class="row">
                    <div class="col-xl-2 col-sm-4 col-12 mb-2 mb-xl-0">
                        <div class="media">
                            <div class="avatar bg-light-primary mr-2">
                                <div class="avatar-content">

                                    <span class="material-symbols-outlined">production_quantity_limits</span>
                                </div>
                            </div>
                            <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{ number_format($vansales) }}</h4>
                                <p class="card-text font-small-3 mb-0">Van Sales</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-4 col-12 mb-2 mb-xl-0">
                        <div class="media">
                            <div class="avatar bg-light-info mr-2">
                                <div class="avatar-content">
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </div>
                            </div>
                            <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{ number_format($preorder) }}</h4>
                                <p class="card-text font-small-3 mb-0">Pre Order</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-4 col-12 mb-2 mb-xl-0">
                        <div class="media">
                            <div class="avatar bg-light-danger mr-2">
                                <div class="avatar-content">
                                 <i data-feather="award  " class="avatar-icon font-medium-3"></i>
                                </div>
                            </div>
                            <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{ number_format($orderfullment) }}</h4>
                                <p class="card-text font-small-3 mb-0">Order Fulfillment</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-4 col-12 mb-2 mb-xl-0">
                        <div class="media">
                            <div class="avatar bg-light-success mr-2">
                                <div class="avatar-content">
                                    <span class="material-symbols-outlined">check_circle</span>
                                </div>
                            </div>
                            <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">
                                 {{ number_format($activeUser) }} / {{  number_format($activeAll) }}
                                </h4>
                                <p class="card-text font-small-3 mb-0">Active Users</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-4 col-12 mb-2 mb-xl-0">
                        <div class="media">
                            <div class="avatar bg-light-success mr-2">
                                <div class="avatar-content">
                                    <i data-feather="truck" class="avatar-icon font-medium-3"></i>
                                </div>
                            </div>
                            <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{ number_format($strike) }}</h4>
                                <p class="card-text font-small-3 mb-0">Visits</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-4 col-12 mb-2 mb-xl-0">
                        <div class="media">
                            <div class="avatar bg-light-success mr-2">
                                <div class="avatar-content">
                                    <span class="material-symbols-outlined">rocket_launch</span>
                                </div>
                            </div>
                            <div class="media-body my-auto">
                                <h4 class="font-weight-bolder mb-0">{{ number_format($customersCount) }}</h4>
                                <p class="card-text font-small-3 mb-0">Buying Customer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Statistics Card -->
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                        type="button" role="tab" aria-controls="pills-home" aria-selected="true">Sales summary</button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <a class="nav-link" href="{!! route('app.dashboard.user.summary') !!}">Employees summary</a>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact"
                        type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Customers
                        summary</button>
                </li> --}}
            </ul>
        </div>
        <div class="col-md-12">
         <div class="col-12">
            <section>
                <div class="row">
                   <div class="col-6">
                      <div class="col-md-12">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="col-md-12">
                                      {!! $brandsales->container() !!}
                                  </div>
                              </div>
                          </div>
                      </div>
                   </div>
                   <div class="col-6">
                      <div class="col-md-12">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="col-md-12">
                                      {!! $catergories->container() !!}
                                  </div>
                              </div>
                          </div>
                      </div>
                   </div>
                </div>
            </section>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-6">
                            <h4>Money Collected</h4>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>Total Collected</th>
                                    <th width="20%"></th>
                                </thead>
                                <tbody>
                                    <tr class="table-success">
                                        <td>Cash</td>
                                        <td>{{ number_format($Cash) }}</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Mpesa</td>
                                        <td>{{ number_format($Mpesa) }}</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Cheque</td>
                                        <td>{{ number_format($Cheque )}}</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Total Reconciled</td>
                                        <td>{{ number_format($total) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6">
                            <h4>Receivables Aging</h4>
                            <table class="table table-striped table-bordered">
                              <thead>
                                 <th>Total Collected</th>
                                 <th width="20%"></th>
                             </thead>
                                <tbody>
                                    <tr class="table-warning">
                                        <td>Today</td>
                                        <td>{{ number_format($daily) }}</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>0-7days</td>
                                        <td>{{ number_format($weekly) }}</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>0-30Days</td>
                                        <td>{{ number_format($monthly) }}</td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td>Total</td>
                                        <td>{{ number_format($sumAll) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
{!! $brandsales->script() !!}
{!! $catergories->script() !!}
    <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/js/charts/apexcharts.min.js') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/js/scripts/pages/dashboard-ecommerce.min.js') !!}">
@endsection
