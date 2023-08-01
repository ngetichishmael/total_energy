
@extends('layouts.app1')
{{-- page header --}}
@section('title', 'Edit Customer')

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
          <span class="bs-stepper-title">Edit Warehouse</span>
          <span class="bs-stepper-subtitle">Edit Warehouse Information</span>
        </span>
      </button>
    </div>


  
  </div>


  <div wire:ignore.self class="bs-stepper-content">
  <div id="customer-details" class="content">
      {!! Form::model($edit, ['route' => ['warehousing.update', $edit->warehouse_code], 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'list-view product-checkout']) !!}
        @csrf
        <div class="card">
          <div class="card-header flex-column align-items-start">
            <h4 class="card-title">Warehouse information</h4>
            <p class="card-text text-muted mt-25">Be sure to enter correct information</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="form-group mb-2">
                  <label for="checkout-name">Warehouse Name:</label>
                  {!! Form::text('name',null,['class'=>'form-control','required'=>'']) !!}
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                  <div class="form-group mb-2">
                     <label for="add-type">Region:</label>
                     <select id="region_id" class="form-control" name="region_id" required>
                           @empty($edit->region)
                              <option value="" selected>Select a Region</option>
                           @endempty
                           @foreach($regions as $region)
                              <option value="{{ $region->id }}" {{ optional($edit->region)->id == $region->id ? 'selected' : '' }}>
                                 {{ $region->name }}
                              </option>
                           @endforeach
                     </select>
                  </div>
               </div>

              <div class="col-md-6 col-sm-12">
                <div class="form-group mb-2">
                  <label for="add-type">Sub Region:</label>
                  <select id="subregion_id" class="form-control" name="subregion_id">
                       <option value=""> {{$edit->subregion->name ?? ''}} </option>
                  </select>
                </div>
              </div>

              <div class="row">
              <div class="col-12 mb-2">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input"  id="accountSwitch1"  name="is_main"  value="Yes" @if($edit->is_main == 'Yes') checked @endif />
                    <label class="custom-control-label" for="accountSwitch1">
                      Is Main Warehouse
                    </label>
                  </div>
                </div>
                <div class="col-12 mb-2">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="accountSwitch2" name="status"  value="Active"  @if($edit->status == 'Active') checked @endif />
                    <label class="custom-control-label" for="accountSwitch2">
                      Is Active
                    </label>
                  </div>
                </div>

                  </div>

     
              <hr class="my-2" />
              <div class="col-12 d-flex justify-content-center" >
                  <button type="submit" class="btn btn-primary btn-next delivery-address mr-2"> Save</button>
                  <a href="{{ url('/warehousing') }}" class="btn btn-outline-secondary">Cancel</a>
              </div>
            </div>
          </div>
        </div>


   
      </form>
    </div>
   

   
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
      $(document).ready(function() {
         $('#region_id').change(function() {
            var regionId = $(this).val();
            if (regionId) {
               $.ajax({
                  url: "{{ route('get-subregions', '') }}/" + regionId,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                     $('#subregion_id').empty();
                     $('#subregion_id').append('<option value="">Choose a Subregion</option>');
                     if (data.length > 0) {
                        $.each(data, function(key, value) {
                           $('#subregion_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                     }
                  }
               });
            } else {
               $('#subregion_id').empty();
            }
         });
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

