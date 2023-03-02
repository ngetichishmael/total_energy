@extends('layouts.app')
{{-- page header --}}
@section('title', 'New Customer')
{{-- page styles --}}


{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->
    <div class="mb-2 row">
        <div class="col-md-8">
            <h2 class="page-header"><i data-feather="users"></i> Customers </h2>
        </div>
        <div class="col-md-4">


        </div>
    </div>
    <!-- Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Customers</h4>
                    </div>
                    <div class="card-body">
                        <form class="form">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Customer Names</label>
                                        <input type="text" id="first-name-column" class="form-control"
                                            placeholder="Customer Name" name="customer_name" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Account</label>
                                        <input type="text" id="last-name-column" class="form-control"
                                            placeholder="Account" name="account" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="city-column">Manufacturer Number</label>
                                        <input type="text" id="city-column" class="form-control" placeholder="City"
                                            name="manufacturer_number" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="country-floating">VAT number</label>
                                        <input type="text" id="country-floating" class="form-control" name="vat_number"
                                            placeholder="VAT number" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Delivery Time</label>
                                        <input type="text" id="company-column" class="form-control" name="delivery_time"
                                            placeholder="Delivery Time" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-id-column">Address</label>
                                        <input type="text" id="email-id-column" class="form-control" name="address"
                                            placeholder="address" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">City</label>
                                        <input type="text" id="first-name-column" class="form-control" placeholder="City"
                                            name="city" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Province</label>
                                        <input type="text" id="last-name-column" class="form-control"
                                            placeholder="Province" name="provice" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="city-column">Postal Code</label>
                                        <input type="text" id="city-column" class="form-control"
                                            placeholder="Postal Code" name="postal_code" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="country-floating">Country</label>
                                        <input type="text" id="country-floating" class="form-control" name="country"
                                            placeholder="Country" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Latitude</label>
                                        <input type="text" id="company-column" class="form-control" name="latitude"
                                            placeholder="Latitude" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-id-column">Longitude</label>
                                        <input type="email" id="email-id-column" class="form-control" name="longitude"
                                            placeholder="Longitude" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Contact Person</label>
                                        <input type="text" id="first-name-column" class="form-control"
                                            placeholder="Contact Person" name="contact_person" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Telephone</label>
                                        <input type="text" id="last-name-column" class="form-control"
                                            placeholder="Telephone" name="telephone" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="city-column">Customer Group</label>
                                        <input type="text" id="city-column" class="form-control"
                                            placeholder="Customer Group" name="customer_group" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="country-floating">Customer Secondary Group</label>
                                        <input type="text" id="country-floating" class="form-control"
                                            name="customer_secondary_group" placeholder="Customer Secondary Group" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Price Group</label>
                                        <input type="text" id="company-column" class="form-control"
                                            name="price_group" placeholder="Price Group" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-id-column">Route</label>
                                        <input type="text" id="email-id-column" class="form-control" name="route"
                                            placeholder="Route" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">Branch</label>
                                        <input type="text" id="first-name-column" class="form-control"
                                            placeholder="Branch" name="branch" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Email</label>
                                        <input type="email" id="last-name-column" class="form-control"
                                            placeholder="Email" name="email" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="city-column">Phone Number</label>
                                        <input type="text" id="city-column" class="form-control"
                                            placeholder="Phone Number" name="phone_number" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="country-floating">Zone</label>
                                        <input type="text" id="country-floating" class="form-control" name="zone"
                                            placeholder="Zone" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Region</label>
                                        <input type="text" id="company-column" class="form-control" name="region"
                                            placeholder="Region" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-id-column">Email</label>
                                        <input type="email" id="email-id-column" class="form-control" name="territory"
                                            placeholder="Email" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">First Name</label>
                                        <input type="text" id="first-name-column" class="form-control"
                                            placeholder="First Name" name="fname-column" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Last Name</label>
                                        <input type="text" id="last-name-column" class="form-control"
                                            placeholder="Last Name" name="lname-column" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="city-column">City</label>
                                        <input type="text" id="city-column" class="form-control" placeholder="City"
                                            name="city-column" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="country-floating">Country</label>
                                        <input type="text" id="country-floating" class="form-control"
                                            name="country-floating" placeholder="Country" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Company</label>
                                        <input type="text" id="company-column" class="form-control"
                                            name="company-column" placeholder="Company" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-id-column">Email</label>
                                        <input type="email" id="email-id-column" class="form-control"
                                            name="email-id-column" placeholder="Email" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column">First Name</label>
                                        <input type="text" id="first-name-column" class="form-control"
                                            placeholder="First Name" name="fname-column" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Last Name</label>
                                        <input type="text" id="last-name-column" class="form-control"
                                            placeholder="Last Name" name="lname-column" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="city-column">City</label>
                                        <input type="text" id="city-column" class="form-control" placeholder="City"
                                            name="city-column" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="country-floating">Country</label>
                                        <input type="text" id="country-floating" class="form-control"
                                            name="country-floating" placeholder="Country" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="company-column">Company</label>
                                        <input type="text" id="company-column" class="form-control"
                                            name="company-column" placeholder="Company" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-id-column">Email</label>
                                        <input type="email" id="email-id-column" class="form-control"
                                            name="email-id-column" placeholder="Email" />
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Floating Label Form section end -->
    <!-- end breadcrumb -->
    {!! Form::open([
        'route' => 'customer.store',
        'class' => 'row',
        'enctype' => 'multipart/form-data',
        'method' => 'post',
    ]) !!}
    @method('POST')
    {!! csrf_field() !!}
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('customer_name', 'Customer names', ['class' => 'control-label']) !!}
                        {!! Form::text('customer_name', null, ['class' => 'form-control', 'placeholder' => 'Enter customer name']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('caccount', 'Account Number', ['class' => 'control-label']) !!}
                        {!! Form::text('account', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('manufacturer_number', 'Manufacturer number', ['class' => 'control-label']) !!}
                        {!! Form::text('manufacturer_number', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('vat_number', 'VAT number', ['class' => 'control-label']) !!}
                        {!! Form::text('vat_number', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('delivery_time', 'Delivery time', ['class' => 'control-label']) !!}
                        <input type="time" class="form-control" name="delivery_time">
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('address', 'Address', ['class' => 'control-label']) !!}
                        {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('city', 'City', ['class' => 'control-label']) !!}
                        {!! Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('province', 'Province', ['class' => 'control-label']) !!}
                        {!! Form::text('province', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('postal_code', 'Postal code', ['class' => 'control-label']) !!}
                        {!! Form::text('postal_code', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('country', 'Country', ['class' => 'control-label']) !!}
                        {!! Form::text('country', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('latitude', 'Latitude', ['class' => 'control-label']) !!}
                        {!! Form::text('latitude', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('longitude', 'Longitude', ['class' => 'control-label']) !!}
                        {!! Form::text('longitude', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('contact_person', 'Contact person	', ['class' => 'control-label']) !!}
                        {!! Form::text('contact_person', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('telephone', 'Telephone', ['class' => 'control-label']) !!}
                        {!! Form::text('telephone', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('customer_group', 'Customer group', ['class' => 'control-label']) !!}
                        {!! Form::text('customer_group', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('customer_secondary_group', 'Customer secondary group', ['class' => 'control-label']) !!}
                        {!! Form::text('customer_secondary_group', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('price_group', 'Price group', ['class' => 'control-label']) !!}
                        {!! Form::text('price_group', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('route', 'Route', ['class' => 'control-label']) !!}
                        {!! Form::text('route', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('branch', 'Branch', ['class' => 'control-label']) !!}
                        {!! Form::text('branch', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('phone_number', 'Phone number', ['class' => 'control-label']) !!}
                        {!! Form::text('phone_number', null, ['class' => 'form-control', 'placeholder' => 'Enter value']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('zone', 'Zone', ['class' => 'control-label']) !!}
                        {!! Form::select('zone', [], null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('Region', 'Region', ['class' => 'control-label']) !!}
                        {!! Form::select('region', [], null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="mb-1 form-group col-md-6">
                        {!! Form::label('Territory', 'Territory', ['class' => 'control-label']) !!}
                        {!! Form::select('territory', [], null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="mb-1 col-md-12">
                        <center><button type="submit" class="btn btn-success">Save Information</button></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
