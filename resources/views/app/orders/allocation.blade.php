
@extends('layouts.app1')

@section('title', 'Order Assign')

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
                    <span class="bs-stepper-title">Assign Order</span>
                    <span class="bs-stepper-subtitle">Assign Order Information</span>
                </span>
            </button>
        </div>
    </div>

    <div wire:ignore.self class="bs-stepper-content">
        <div id="customer-details" class="content">
            <form class="list-view product-checkout" action="{!! route('order.create.allocateorders') !!}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_code" value="{!! $order->order_code !!}">
                <input type="hidden" name="customer" value="{!! $order->customerID !!}">
                <div class="card">
                    <div class="card-header flex-column align-items-start">
                        <h4 class="card-title">Assigning Order</h4>
                        <p class="card-text text-muted mt-25">Be sure to enter correct information</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="">Assign Stock To</label>
                                <select name="account_type" class="form-control select" id="account_type" required>
                                    <option value="">Choose User Type</option>
                                    @foreach ($account_types as $account)
                                    <option value="{!! $account->account_type !!}">{!! $account->account_type !!}</option>
                                    @endforeach
                                    <!-- <option value="distributors">Distributors</option> -->
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Choose User</label>
                                <select name="user" class="form-control select2" id="user" required>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group ml-0 pe-0 col-md-3">
                                <label for="warehouse">Warehouse:</label>
                                <select id="warehouse" class="form-control select2" name="warehouse_code" required>
                                    <option value="" class="focus:bg-gray-400">Select a Warehouse</option>
                                    @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->warehouse_code }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Delivery Date</label>
                                    <input type="date" name="delivery_date[]" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group ml-0 pe-0 col-md-3">
                                <label for="noteText">Note</label>
                                <textarea name="note" class="form-control" id="noteTxt" rows="3"
                                    placeholder="Provide a description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-2" />
           
            <div class="card">
                <div class="card-header flex-column align-items-start">
                    <h4 class="card-title">Assigning Products</h4>
                    <p class="card-text text-muted mt-25">Be sure to enter correct information</p>
                </div>
                <div class="card-body">
                    @foreach ($items as $key => $item)
                    <input type="hidden" name="item_code[]" value="{!! $item->productID !!}">
                    <div class="mb-1 row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Product</label>
                                <input type="text" name="product[]" value="{!! $item->product_name !!}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input type="text" name="requested[]" value="{!! $item->quantity !!}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Total Price (Ksh.)</label>
                                <input type="text" value="{!! $item->selling_price * $item->quantity !!}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Allocate</label>
                                <input type="number" name="allocate[]" class="form-control"
                                    placeholder="max {!! $item->quantity !!}" max="{!! $item->quantity !!}" required
                                    oninput="calculatePrice(this, {!! $item->selling_price !!})">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Updated Price</label>
                                <input type="number" name="price[]" class="form-control"
                                    style="background: #fa8760; color: rgba(0,0,0,0.82)" required readonly>
                            </div>
                        </div>
                        <script>
                            function calculatePrice(input, sellingPrice) {
                                const allocatedQuantity = input.value;
                                const totalPrice = allocatedQuantity * sellingPrice;
                                const priceInput = input.closest('.col-md-2').nextElementSibling
                                    .querySelector('input[name="price[]"]');
                                priceInput.value = totalPrice;
                            }
                        </script>
                    </div>
                    <hr class="my-2" />
                    @endforeach
                    <div class="col-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn btn-next delivery-address mr-2"
                            style="background-color:#1877F2; color:#ffffff;"> Save</button>
                        <a href="{{ url('/pendingorders') }}" class="btn btn-outline-secondary">Cancel</a>
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
        $('#account_type').on('change', function() {
            var accountType = $(this).val();
            if (accountType === 'distributors') {
                $.ajax({
                    url: '{{ route('get.distributors') }}',
                    type: 'GET',
                    success: function(data) {
                        $('#user').empty();
                        $('#user').append('<option value="">Choose a Distributor</option>');
                        data.users.forEach(function(distributor) {
                            $('#user').append('<option value="' + distributor.id + '">' + distributor.name +
                                '</option>');
                        });
                    },
                    error: function($e) {
                        console.log($e);
                        console.log('Error occurred during AJAX request.');
                    }
                });
            } else if (accountType) {
                $.ajax({
                    url: '{{ route('get.users') }}',
                    type: 'GET',
                    data: { account_type: accountType },
                    success: function(data) {
                        $('#user').empty();
                        $('#user').append('<option value="">Choose a User</option>');
                        data.users.forEach(function(user) {
                            $('#user').append('<option value="' + user.user_code + '">' + user.name +
                                '</option>');
                        });
                    },
                    error: function() {
                        console.log('Error occurred during AJAX request.');
                    }
                });
            } else {
                $('#user').empty();
                $('#user').append('<option value="">Choose User</option>');
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
