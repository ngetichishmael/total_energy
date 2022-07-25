@extends('layouts.app')
@section('title','Dashboard')
@section('stylesheets')
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/plugins/charts/chart-apex.min.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/pages/dashboard-ecommerce.min.css') !!}">
@endsection
@section('content')
   <div class="row">
      <div class="col-md-12">
         <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Sales summary</button>
            </li>
            <li class="nav-item" role="presentation">
               <a class="nav-link" href="{!! route('app.dashboard.user.summary') !!}">Employees summary</a>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Customers summary</button>
            </li>
          </ul>
      </div>
      <div class="col-md-12">
         <div class="row">
            <div class="col-md-4">
               <div class="col-md-12">
                  <h4>Money Collected</h4>
                  <table class="table table-striped table-bordered">
                     <thead>
                        <th>Total Collected</th>
                        <th width="20%">0.00</th>
                     </thead>
                     <tbody>
                        <tr class="table-success">
                           <td>Cash</td>
                           <td>00</td>
                        </tr>
                        <tr class="table-success">
                           <td>Mpesa</td>
                           <td>00</td>
                        </tr>
                        <tr class="table-success">
                           <td>Cheque</td>
                           <td>00</td>
                        </tr>
                        <tr class="table-success">
                           <td>Not Yet Reconcilled</td>
                           <td>00</td>
                        </tr>
                        <tr class="table-success">
                           <td>Reconcilled Not Approved</td>
                           <td>00</td>
                        </tr>
                        <tr class="table-success">
                           <td>Reconcilled Approved</td>
                           <td>00</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <div class="col-md-12">
                  <h4>Receivables Aging</h4>
                  <table class="table table-striped table-bordered">
                     <tbody>
                        <tr class="table-warning">
                           <td>0-30 Days</td>
                           <td>0</td>
                           <td>00</td>
                        </tr>
                        <tr class="table-warning">
                           <td>31-60 Days</td>
                           <td>0</td>
                           <td>00</td>
                        </tr>
                        <tr class="table-warning">
                           <td>61-90 Days</td>
                           <td>0</td>
                           <td>00</td>
                        </tr>
                        <tr class="table-warning">
                           <td>90+ Days</td>
                           <td>0</td>
                           <td>00</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="col-md-8">
               <div class="row">

                  <div class="col-xl-3 col-md-3 col-sm-6">
                     <div class="card text-center">
                        <div class="card-body">
                           <div class="avatar bg-light-danger p-50 mb-1">
                              <div class="avatar-content">
                              <i data-feather="shopping-bag" class="font-medium-5"></i>
                              </div>
                           </div>
                           <h2 class="fw-bolder">0.00</h2>
                           <p class="card-text">Total Sales Amount</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-md-3 col-sm-6">
                     <div class="card text-center">
                        <div class="card-body">
                           <div class="avatar bg-light-danger p-50 mb-1">
                              <div class="avatar-content">
                              <i data-feather="shopping-bag" class="font-medium-5"></i>
                              </div>
                           </div>
                           <h2 class="fw-bolder">0.00</h2>
                           <p class="card-text">Sales Count</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-md-3 col-sm-6">
                     <div class="card text-center">
                        <div class="card-body">
                           <div class="avatar bg-light-danger p-50 mb-1">
                              <div class="avatar-content">
                              <i data-feather="shopping-bag" class="font-medium-5"></i>
                              </div>
                           </div>
                           <h2 class="fw-bolder">0.00</h2>
                           <p class="card-text">Sales NonCredit [0]</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-md-3 col-sm-6">
                     <div class="card text-center">
                        <div class="card-body">
                           <div class="avatar bg-light-danger p-50 mb-1">
                              <div class="avatar-content">
                              <i data-feather="shopping-bag" class="font-medium-5"></i>
                              </div>
                           </div>
                           <h2 class="fw-bolder">0.00</h2>
                           <p class="card-text">Sales Credit [0]</p>
                        </div>
                     </div>
                  </div>

                  <div class="col-md-12">
                     <div class="card" style="height: 340px">
                        <div class="card-body">

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/js/charts/apexcharts.min.js') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/js/scripts/pages/dashboard-ecommerce.min.js') !!}">
@endsection
