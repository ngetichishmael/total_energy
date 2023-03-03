@extends('layouts.app')
{{-- page header --}}
@section('title', 'Edit Customer')
{{-- page styles --}}

{{-- content section --}}
@section('content')
    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start">Customer | Edit</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Customer</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-8">
                c <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Customers</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" method="POST"
                            action="{{ route('customer.update', ['customer' => $customer]) }}">

                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Customer Names</label>
                                        <input type="text" id="first-name-column" class="form-control"
                                            placeholder="Customer Name" name="customer_name"
                                            value="{{ $customer->customer_name }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Account</label>
                                        <input type="text" id="last-name-column" class="form-control"
                                            placeholder="Account" name="account" value="{{ $customer->account }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="city-column">Manufacturer Number</label>
                                        <input type="text" id="city-column" class="form-control" placeholder="City"
                                            name="manufacturer_number" value="{{ $customer->manufacturer_number }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="country-floating">VAT number</label>
                                        <input type="text" id="country-floating" class="form-control" name="vat_number"
                                            placeholder="VAT number" value="{{ $customer->vat_number }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Delivery Time</label>
                                        <input type="text" id="company-column" class="form-control" name="delivery_time"
                                            placeholder="Delivery Time" value="{{ $customer->delivery_time }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-id-column">Address</label>
                                        <input type="text" id="email-id-column" class="form-control" name="address"
                                            placeholder="address" value="{{ $customer->address }}" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">City</label>
                                        <input type="text" id="first-name-column" class="form-control" placeholder="City"
                                            name="city" value="{{ $customer->city }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Province</label>
                                        <input type="text" id="last-name-column" class="form-control"
                                            placeholder="Province" name="province" value="{{ $customer->province }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="city-column">Postal Code</label>
                                        <input type="text" id="city-column" class="form-control"
                                            placeholder="Postal Code" name="postal_code"
                                            value="{{ $customer->postal_code }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="country-floating">Country</label>
                                        <input type="text" id="country-floating" class="form-control" name="country"
                                            placeholder="Country" value="{{ $customer->country }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Latitude</label>
                                        <input type="text" id="company-column" class="form-control" name="latitude"
                                            placeholder="Latitude" value="{{ $customer->latitude }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-id-column">Longitude</label>
                                        <input type="email" id="email-id-column" class="form-control" name="longitude"
                                            placeholder="Longitude" value="{{ $customer->longitude }}" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Contact Person</label>
                                        <input type="text" id="first-name-column" class="form-control"
                                            placeholder="Contact Person" name="contact_person"
                                            value="{{ $customer->contact_person }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Telephone</label>
                                        <input type="text" id="last-name-column" class="form-control"
                                            placeholder="Telephone" name="telephone"
                                            value="{{ $customer->telephone }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="city-column">Customer Group</label>
                                        <input type="text" id="city-column" class="form-control"
                                            placeholder="Customer Group" name="customer_group"
                                            value="{{ $customer->customer_group }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="country-floating">Customer Secondary Group</label>
                                        <input type="text" id="country-floating" class="form-control"
                                            name="customer_secondary_group" placeholder="Customer Secondary Group"
                                            value="{{ $customer->customer_secondary_group }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Price Group</label>
                                        <input type="text" id="company-column" class="form-control"
                                            name="price_group" placeholder="Price Group"
                                            value="{{ $customer->price_group }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-id-column">Route</label>
                                        <input type="text" id="email-id-column" class="form-control" name="route"
                                            placeholder="Route" value="{{ $customer->route }}" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Branch</label>
                                        <input type="text" id="first-name-column" class="form-control"
                                            placeholder="Branch" name="branch" value="{{ $customer->branch }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Email</label>
                                        <input type="email" id="last-name-column" class="form-control"
                                            placeholder="Email" name="email" value="{{ $customer->email }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="city-column">Phone Number</label>
                                        <input type="text" id="city-column" class="form-control"
                                            placeholder="Phone Number" name="phone_number"
                                            value="{{ $customer->phone_number }}" />
                                    </div>
                                </div>
                                @livewire('customers.region')
                            </div>
                            <div class="my-1 col-sm-9 offset-sm-3">
                                <button type="submit" class="mr-1 btn btn-primary">Update</button>
                                <a href="{{ route('customer') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Floating Label Form section end -->

@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
