@extends('layouts.app1')
{{-- page header --}}
@section('title', 'Re Stock Products')

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
                        <span class="bs-stepper-title">Restock <b>{{ $product_information->product_name ?? '' }}</b>
                        </span>
                        <span class="bs-stepper-subtitle">Stock Information</span>
                    </span>
                </button>
            </div>



        </div>


        <div wire:ignore.self class="bs-stepper-content">
            <div id="customer-details" class="content">
                <form action="{{ route('products.updatestock', ['id' => $id]) }}" method="POST"
                    enctype="multipart/form-data" id="restock-form" class="list-view product-checkout">
                    @csrf
                    <div class="card">
                        <div class="card-header flex-column align-items-start">
                            <h4 class="card-title">Product information</h4>
                            <p class="card-text text-muted mt-25">Be sure to enter correct information</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <style>
                                    /* Custom styles for readonly inputs */
                                    input[readonly] {
                                        background-color: #f5f5f5;
                                        /* Light grey background */
                                        border-color: #ddd;
                                        /* Lighter border */
                                    }
                                </style>

                                <table id="sku-table responsive">
                                    <thead>
                                        <tr>
                                            <th>Product SKU Code</th>
                                            <th>Current Quantity</th>
                                            <th>Restock Quantity </th>
                                        </tr>
                                    </thead>
                                    <tbody id="sku-fields">
                                        <tr class="sku-field ">
                                            <td><input for="fp-date-time" type="text" class="form-control-sm"
                                                    name="sku_codes[]" value="{{ $product_information->sku_code }}"
                                                    readonly required></td>
                                            <td><input for="fp-date-time" type="text" class="form-control-sm"
                                                    value="{{ $product_information->inventory->current_stock ?? 0 }}"
                                                    readonly>
                                            </td>
                                            <td><input for="fp-date-time" type="number" class="form-control-sm"
                                                    min="1" name="quantities[]" required></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <hr class="my-2" />
                                <div class="col-12 d-flex justify-content-center">
                                    <button wire:click.prevent="submit()" type="submit"
                                        class="btn btn-primary btn-next delivery-address mr-2"> Save</button>
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
            <td><input for="fp-date-time" type="text" class="form-control-sm" name="sku_codes[]" required></td>
             <td><input for="fp-date-time" type="number" class="form-control-sm" name="quantities[]" required></td>
             <td><button for="fp-date-time"  type="button" class="remove-sku form-control btn btn-sm btn-outline-danger" style="width: fit-content">
                    <i class="fas fa-trash mr-25"></i><span> &nbsp;Delete</span></button>
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
