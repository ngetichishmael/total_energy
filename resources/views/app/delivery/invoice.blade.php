@extends('layouts.app1')


{{-- page header --}}
@section('title', 'Order Details')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
<link rel="stylesheet" href="{{asset('css/base/pages/app-invoice.css')}}">
@endsection

@section('content')
<div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-10">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start">Delivery Details</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/sokoflowadmin">Home</a></li>
                            <li class="breadcrumb-item"><a href="{!! route('orders.index') !!}">Delivery</a></li>
                            <li class="breadcrumb-item active">{!! $code !!}</li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<section class="invoice-preview-wrapper" >
      @include('partials._messages')
  <div class="row invoice-preview" >
    <!-- Invoice -->
    <div class="col-xl-10 col-md-2 col-12" style="padding-left:10%;">
      <div class="card invoice-preview-card">
        <div class="card-body invoice-padding pb-0">
          <!-- Header starts -->
          <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
            <div>
            @foreach ($deliveries as $count => $deliver)
              <div class="logo-wrapper">
              <img style="height:50px;" src={{ asset('app-assets/images/small_logo.png') }} alt="Soko Flow" />
              </div>

                    <p class="card-text mb-25"> {{ $deliver->Customer->customer_name ?? ''}}   23 Olenguruone Avenue, Kileleshwa</p>
                        <p class="card-text mb-25">P.O. Box 15478-00100 City Square, Nairobi</p>
                        <p class="mb-0 card-text">+254 748 424 757, +254 724 032 354</p>
                        <p class="mb-0 card-text">info@deveint.com</p>
            </div>
            <div class="mt-md-0 mt-2">
      
              <h4 class="invoice-title">
                Delivery ID
                <span class="invoice-number">#{{ $deliver->delivery_code }}</span>
              </h4>
              <div class="invoice-date-wrapper">
                <p class="invoice-date-title">Delivery Date:</p>
                <p class="invoice-date">{{ optional($deliver->delivered_time)->format('Y-m-d h:i A') ?? 'Not Set' }}</p>
              </div>
        
                <div class="invoice-date-wrapper">
                <p class="invoice-date-title">Status:</p>
               
                <p class="invoice-date"> 
                @if ($deliver->delivery_status === 'DELIVERED')
                     <span class="badge badge-pill badge-light-success mr-1"> {{ $deliver->delivery_status ?? '' }} </span>
                @else
                     <span class="badge badge-pill badge-light-warning mr-1">{{ $deliver->delivery_status ?? '' }}</span>
                @endif
              </div>
            </div>
          </div>
          <!-- Header ends -->
        </div>

        <hr class="invoice-spacing" />

        

        <!-- Invoice Description starts -->
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th class="py-1">Description</th>
                <th class="py-1">Unit Price</th>
                <th class="py-1">Qty</th>
                <th class="py-1">Total</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($deliver->OrderItems as $key => $value)
              <tr class="border-bottom">
                <td class="py-1">
                  <p class="card-text font-weight-bold mb-25"> {{ $value->product_name ?? ''}} </p>
                  <p class="card-text text-nowrap">
                 SKU
                  </p>
                </td>
                        @php
                           $subtotal=$subtotal+$value->sub_total;
                        @endphp
                <td class="py-1">
                  <span class="font-weight-bold">ksh {{ number_format($value->selling_price) }}</span>
                </td>
                <td class="py-1">
                  <span class="font-weight-bold">{{ $value->quantity }}</span>
                </td>
                         @php
                            $total=$total+$value->total_amount;
                         @endphp
                <td class="py-1">
                  <span class="font-weight-bold"> ksh {{ number_format($value->total_amount) }}</span>
                </td>
              </tr>
             @endforeach

     
            </tbody>
          </table>
        </div>

        <div class="card-body invoice-padding pb-0">
          <div class="row invoice-sales-total-wrapper">
            <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
              <p class="card-text mb-0">
                <span class="font-weight-bold">Salesperson:</span> <span class="ml-75"> {{ $deliver->User->name }}</span>
              </p>
            </div>
            <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
              <div class="invoice-total-wrapper">
                <div class="invoice-total-item">
                  <p class="invoice-total-title">Subtotal:</p>
                  <p class="invoice-total-amount"> Ksh {{ number_format($subtotal) }} </p>
                </div>
                <div class="invoice-total-item">
                  <p class="invoice-total-title">Discount:</p>
                  <p class="invoice-total-amount">Ksh 0.0</p>
                </div>
                <!-- <div class="invoice-total-item">
                  <p class="invoice-total-title">Tax:</p>
                  <p class="invoice-total-amount">1%</p>
                </div> -->
                <hr class="my-50" />
                <div class="invoice-total-item">
                  <p class="invoice-total-title">Total:</p>
                  <p class="invoice-total-amount"> Ksh {{ number_format($total) }} </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Invoice Description ends -->
        @endforeach
        <hr class="invoice-spacing" />

        <!-- Invoice Note starts -->
        <div class="card-body invoice-padding pt-0">
          <div class="row">
            <div class="col-12">
              <span class="font-weight-bold">Notes:</span>
              <span> {{ $deliver->delivery_note ?? 'No delivery note !! ...' }}</span
              >
            </div>
          </div>
        </div>
        <!-- Invoice Note ends -->
      </div>
    </div>
    <!-- /Invoice -->

   
  </div>
</section>

@endsection

@section('vendor-script')
<script src="{{asset('vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
@endsection