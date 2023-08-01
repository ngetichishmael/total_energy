
@extends('layouts.app1')
{{-- page header --}}
@section('title', 'Assign  Warehouse Manager')

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
          <span class="bs-stepper-title"> Assign  Warehouse Manager </span>
          <span class="bs-stepper-subtitle">Assign Manager</span>
        </span>
      </button>
    </div>


  
  </div>


  <div wire:ignore.self class="bs-stepper-content">
  <div id="customer-details" class="content">
      <form action="{{ route('warehousing.assignwarehouse', ['code' => $code]) }}" method="POST"  enctype="multipart/form-data" id="restock-form" class="list-view product-checkout">
        @csrf
        <div class="card">
          <div class="card-header flex-column align-items-start">
            <h4 class="card-title">Provide a Manager to a warehouse </h4>
            <p class="card-text text-muted mt-25">Be sure to enter correct information</p>
          </div>
          <div class="card-body">
            <div class="row">
            <table id="sku-table" class="responsive" >
    <thead class="thead-light">
        <tr>
            <th style="padding-left:20px;">Sales Force</th>
            <th style="padding-left:20px;">Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="sku-fields">
        <tr class="sku-field">
            <td class="col-md-4 col-sm-12">
                <select class="form-control select2" name="shopattendee[]" style="width:100%" required>
                    <option value="">-- Choose Warehouse Manager --</option>
                    @foreach ($shopattendee as $user)
                    <option value="{{ $user->user_code }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="warehouse" value="{{ $code }}">
            </td>
            <td class="col-md-4 col-sm-12">
                <select class="form-control select2" name="position[]" required>
                    <option value="">-- Choose role --</option>
                    <option value="lead">Lead</option>
                    <option value="Assistant">Assistant</option>
                    <option value="Other">Other</option>
                </select>
            </td>
            <td class="col-md-4 col-sm-12">
                <button for="fp-date-time" type="button" class="remove-sku form-control btn btn-sm btn-outline-danger" style="width: fit-content">
                    <span> &nbsp;Delete</span>
                </button>
            </td>
        </tr>
    </tbody>
</table>


            <div class="row">
               <div class="col-md-12 m-2">
                  <button wire:click.prevent="addTargets" type="button" id="add-sku" class="btn btn-outline-primary">
                        <i data-feather="plus" class="mr-25 font-medium bold"></i>
                        <span>Add New Row</span>
                  </button>
               </div>
            </div>
     
              <hr class="my-2" />
              <div class="col-12 d-flex justify-content-center" >
                  <button wire:click.prevent="submit()" type="submit" class="btn btn-primary btn-next delivery-address mr-2"> Save</button>
                  <a href="{{ url('/warehousing') }}" class="btn btn-outline-secondary">Cancel</a>
              </div>
            </div>
          </div>
        </div>


   
      </form>
    </div>
   

   
  </div>
</div>

<script>
      // Add SKU field
      document.getElementById('add-sku').addEventListener('click', function() {
         var skuFields = document.getElementById('sku-fields');
         var newField = document.createElement('tr');
         newField.classList.add('sku-field');
         newField.innerHTML = `
            <td class="col-md-4 col-sm-12" style="padding:12px">
               <select  class="form-control select2" name="shopattendee[]" required>
                  <option value="" selected>-- Choose Warehouse Manager --</option>
                  @foreach ($shopattendee as $user)
         <option value="{{ $user->user_code }}">{{ $user->name }}</option>
                  @endforeach
         </select>
         </td>
       <td class="col-md-4 col-sm-12">
               <select  class="form-control select2" name="position[]" required>
                  <option value="" selected>-- choose role --</option>
                  <option value="lead">Lead</option>
                  <option value="Assistant">Assistant</option>
                  <option value="Other">Other</option>
               </select>
            </td>
      <td class="col-md-4 col-sm-12"><button for="fp-date-time"  type="button" class="remove-sku form-control btn btn-sm btn-outline-danger" style="width: fit-content">
            <span> &nbsp;Delete</span></button>
      </td>
`;
         skuFields.appendChild(newField);
      });

      // Remove SKU field
      document.addEventListener('click', function(event) {
         if (event.target.classList.contains('remove-sku')) {
            var skuField = event.target.closest('.sku-field');
            skuField.parentNode.removeChild(skuField);
         }
      });
   </script>
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

