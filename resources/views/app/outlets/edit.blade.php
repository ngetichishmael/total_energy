
@extends('layouts.app1')

@section('title', 'Edit Customer Outlet')

@section('vendor-style')
  <!-- Vendor css files -->
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/wizard/bs-stepper.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">


  <link rel="stylesheet" href="{{ asset('vendors/css/vendors.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendors/css/ui/prism.min.css') }}" />

<!-- Vendor css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/forms/wizard/bs-stepper.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/core.css') }}" />
<link rel="stylesheet" href="{{ asset('css/base/core/menu/menu-types/vertical-menu.css') }}" />
<!-- <link rel="stylesheet" href="{{ asset('css/base/core/colors/palette-gradient.css') }}"> -->

<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-pickadate.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-wizard.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-number-input.css') }}">

<link rel="stylesheet" href="{{ asset('css/overrides.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">


@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-pickadate.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-wizard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-number-input.css') }}">
@endsection




@section('content')

<div class="bs-stepper checkout-tab-steps">
  <div class="bs-stepper-header">
    <div class="step" data-target="#customer-details">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-box">
          <i data-feather='globe' class="font-medium-3"></i>
        </span>
        <span class="bs-stepper-label">
          <span class="bs-stepper-title">Edit Outlet</span>
          <span class="bs-stepper-subtitle">Outlet Information</span>
        </span>
      </button>
    </div>


  
  </div>


  <div wire:ignore.self class="bs-stepper-content">
  <div id="customer-details" class="content">
      <form action="{{ route('outlets.update',$edit->id) }}" method="POST" class="list-view product-checkout">
        @csrf
        <div class="card">
          <div class="card-header flex-column align-items-start">
            <h4 class="card-title">Outlet information</h4>
            <p class="card-text text-muted mt-25">Be sure to enter correct information</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="form-group mb-2">
                  <label for="checkout-name">Outlet Name:</label>
                  <input type="text" id="outlet_name" class="form-control" value="{{ $edit->outlet_name }}"
                                        name="outlet_name" required />                </div>
              </div>


     
              <hr class="my-2" />
              <div class="col-12 d-flex justify-content-center" >
                  <button type="submit" class="btn btn btn-next delivery-address mr-2" style="background-color:#1877F2; color:#ffffff;"> Save</button>
                  <a href="{{ url('/customer/outlets') }}" class="btn btn-outline-secondary">Cancel</a>
              </div>
            </div>
          </div>
        </div>


   
      </form>
    </div>
   

   
  </div>
</div>



@endsection

@section('vendor-script')
  <!-- Vendor js files -->
  <script src="{{ asset('vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
  <script src="{{ asset('js/scripts/pages/app-ecommerce-checkout.js') }}"></script>


  <script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('vendors/js/ui/prism.min.js') }}"></script>

<!-- Vendor js files -->
<script src="{{ asset('vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>

<script src="{{ asset('js/core/app-menu.js') }}"></script>
<script src="{{ asset('js/core/app.js') }}"></script>
<script src="{{ asset('js/scripts/customizer.js') }}"></script>

<!-- Page js files -->
<script src="{{ asset('js/scripts/pages/app-ecommerce-checkout.js') }}"></script>

@endsection

