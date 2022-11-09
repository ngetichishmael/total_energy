@extends('layouts.app')

@section('stylesheets')
    <style>
        .brc-default-l1 {
            border-color: #dce9f0 !important;
        }

        .ml-n1,
        .mx-n1 {
            margin-left: -.25rem !important;
        }

        .mr-n1,
        .mx-n1 {
            margin-right: -.25rem !important;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        .text-grey-m2 {
            color: #888a8d !important;
        }

        .text-success-m2 {
            color: #86bd68 !important;
        }

        .font-bolder,
        .text-600 {
            font-weight: 600 !important;
        }

        .text-110 {
            font-size: 110% !important;
        }

        .text-blue {
            color: #478fcc !important;
        }

        .pb-25,
        .py-25 {
            padding-bottom: .75rem !important;
        }

        .pt-25,
        .py-25 {
            padding-top: .75rem !important;
        }

        .bgc-default-tp1 {
            background-color: rgba(121, 169, 197, .92) !important;
        }

        .bgc-default-l4,
        .bgc-h-default-l4:hover {
            background-color: #f3f8fa !important;
        }

        .page-header .page-tools {
            -ms-flex-item-align: end;
            align-self: flex-end;
        }

        .btn-light {
            color: #757984;
            background-color: #f5f6f9;
            border-color: #dddfe4;
        }

        .w-2 {
            width: 1rem;
        }

        .text-120 {
            font-size: 120% !important;
        }

        .text-primary-m1 {
            color: #4087d4 !important;
        }

        .text-danger-m1 {
            color: #dd4949 !important;
        }

        .text-blue-m2 {
            color: #68a3d5 !important;
        }

        .text-150 {
            font-size: 150% !important;
        }

        .text-60 {
            font-size: 60% !important;
        }

        .text-grey-m1 {
            color: #7b7d81 !important;
        }

        .align-bottom {
            vertical-align: bottom !important;
        }
    </style>
@endsection
{{-- page header --}}
@section('title', 'Delivery Details')

{{-- content section --}}
@section('content')
    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start">Delivery Details</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/sokoflowadmin">Home</a></li>
                            <li class="breadcrumb-item"><a href="{!! route('orders.index') !!}">Delivery</a></li>
                            <li class="breadcrumb-item active">{!! $order->order_code !!}</li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials._messages')
     <!-- Invoice -->
     <div class="col-xl-9 col-md-8 col-12">
      <div class="card invoice-preview-card">
        <div class="pb-0 card-body invoice-padding">
          <!-- Header starts -->
          <div class="mt-0 d-flex justify-content-between flex-md-row flex-column invoice-spacing">
            <div>
              <div class="logo-wrapper">
                <svg
                  viewBox="0 0 139 95"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  height="24"
                >
                  <defs>
                    <linearGradient id="invoice-linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                      <stop stop-color="#000000" offset="0%"></stop>
                      <stop stop-color="#FFFFFF" offset="100%"></stop>
                    </linearGradient>
                    <linearGradient
                      id="invoice-linearGradient-2"
                      x1="64.0437835%"
                      y1="46.3276743%"
                      x2="37.373316%"
                      y2="100%"
                    >
                      <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                      <stop stop-color="#FFFFFF" offset="100%"></stop>
                    </linearGradient>
                  </defs>
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-400.000000, -178.000000)">
                      <g transform="translate(400.000000, 178.000000)">
                        <path
                          class="text-primary"
                          d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                          style="fill: currentColor"
                        ></path>
                        <path
                          d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                          fill="url(#invoice-linearGradient-1)"
                          opacity="0.2"
                        ></path>
                        <polygon
                          fill="#000000"
                          opacity="0.049999997"
                          points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"
                        ></polygon>
                        <polygon
                          fill="#000000"
                          opacity="0.099999994"
                          points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"
                        ></polygon>
                        <polygon
                          fill="url(#invoice-linearGradient-2)"
                          opacity="0.099999994"
                          points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"
                        ></polygon>
                      </g>
                    </g>
                  </g>
                </svg>
                <h3 class="text-primary invoice-logo">Vuexy</h3>
              </div>
              <p class="card-text mb-25">Office 149, 450 South Brand Brooklyn</p>
              <p class="card-text mb-25">San Diego County, CA 91905, USA</p>
              <p class="mb-0 card-text">+1 (123) 456 7891, +44 (876) 543 2198</p>
            </div>
            <div class="mt-2 mt-md-0">
              <h4 class="invoice-title">
                Invoice
                <span class="invoice-number">#3492</span>
              </h4>
              <div class="invoice-date-wrapper">
                <p class="invoice-date-title">Date Issued:</p>
                <p class="invoice-date">25/08/2020</p>
              </div>
              <div class="invoice-date-wrapper">
                <p class="invoice-date-title">Due Date:</p>
                <p class="invoice-date">29/08/2020</p>
              </div>
            </div>
          </div>
          <!-- Header ends -->
        </div>

        <hr class="invoice-spacing" />

        <!-- Address and Contact starts -->
        <div class="pt-0 card-body invoice-padding">
          <div class="row invoice-spacing">
            <div class="p-0 col-xl-8">
              <h6 class="mb-2">Invoice To:</h6>
              <h6 class="mb-25">Thomas shelby</h6>
              <p class="card-text mb-25">Shelby Company Limited</p>
              <p class="card-text mb-25">Small Heath, B10 0HF, UK</p>
              <p class="card-text mb-25">718-986-6062</p>
              <p class="mb-0 card-text">peakyFBlinders@gmail.com</p>
            </div>
            <div class="p-0 mt-2 col-xl-4 mt-xl-0">
              <h6 class="mb-2">Payment Details:</h6>
              <table>
                <tbody>
                  <tr>
                    <td class="pr-1">Total Due:</td>
                    <td><span class="font-weight-bold">$12,110.55</span></td>
                  </tr>
                  <tr>
                    <td class="pr-1">Bank name:</td>
                    <td>American Bank</td>
                  </tr>
                  <tr>
                    <td class="pr-1">Country:</td>
                    <td>United States</td>
                  </tr>
                  <tr>
                    <td class="pr-1">IBAN:</td>
                    <td>ETD95476213874685</td>
                  </tr>
                  <tr>
                    <td class="pr-1">SWIFT code:</td>
                    <td>BR91905</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Address and Contact ends -->

        <!-- Invoice Description starts -->
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th class="py-1">Task description</th>
                <th class="py-1">Rate</th>
                <th class="py-1">Hours</th>
                <th class="py-1">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="py-1">
                  <p class="card-text font-weight-bold mb-25">Native App Development</p>
                  <p class="card-text text-nowrap">
                    Developed a full stack native app using React Native, Bootstrap & Python
                  </p>
                </td>
                <td class="py-1">
                  <span class="font-weight-bold">$60.00</span>
                </td>
                <td class="py-1">
                  <span class="font-weight-bold">30</span>
                </td>
                <td class="py-1">
                  <span class="font-weight-bold">$1,800.00</span>
                </td>
              </tr>
              <tr class="border-bottom">
                <td class="py-1">
                  <p class="card-text font-weight-bold mb-25">Ui Kit Design</p>
                  <p class="card-text text-nowrap">Designed a UI kit for native app using Sketch, Figma & Adobe XD</p>
                </td>
                <td class="py-1">
                  <span class="font-weight-bold">$60.00</span>
                </td>
                <td class="py-1">
                  <span class="font-weight-bold">20</span>
                </td>
                <td class="py-1">
                  <span class="font-weight-bold">$1200.00</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="pb-0 card-body invoice-padding">
          <div class="row invoice-sales-total-wrapper">
            <div class="order-2 mt-3 col-md-6 order-md-1 mt-md-0">
              <p class="mb-0 card-text">
                <span class="font-weight-bold">Salesperson:</span> <span class="ml-75">Alfie Solomons</span>
              </p>
            </div>
            <div class="order-2 col-md-6 d-flex justify-content-end col-md-2">
              <div class="col-6">
                <div class="invoice-total-item">
                  <p class="invoice-total-title">Subtotal:</p>
                  <p class="invoice-total-amount">$1800</p>
                </div>
                <div class="invoice-total-item">
                  <p class="invoice-total-title">Discount:</p>
                  <p class="invoice-total-amount">$28</p>
                </div>
                <div class="invoice-total-item">
                  <p class="invoice-total-title">Tax:</p>
                  <p class="invoice-total-amount">21%</p>
                </div>
                <hr class="my-50" />
                <div class="invoice-total-item">
                  <p class="invoice-total-title">Total:</p>
                  <p class="invoice-total-amount">$1690</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Invoice Description ends -->

        <hr class="invoice-spacing" />

        <!-- Invoice Note starts -->
        <div class="pt-0 card-body invoice-padding">
          <div class="row">
            <div class="col-12">
              <span class="font-weight-bold">Note:</span>
              <span
                >It was a pleasure working with you and your team. We hope you will keep us in mind for future freelance
                projects. Thank You!</span
              >
            </div>
          </div>
        </div>
        <!-- Invoice Note ends -->
      </div>
    </div>
    <!-- /Invoice -->
@endsection
{{-- page scripts --}}
@section('script')

@endsection
