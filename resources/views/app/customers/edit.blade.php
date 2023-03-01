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
    <!-- Basic Floating Label Form section end -->
    <!-- end breadcrumb -->
    {!! Form::model($customer, [
        'route' => ['customer.update', $customer->id],
        'method' => 'post',
        'enctype' => 'multipart/form-data',
    ]) !!}
    @method('PUT')
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
                        <input type="time" class="form-control" value="{!! $customer->delivery_time !!}" name="delivery_time">
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
                        <center><button type="submit" class="btn btn-success">Update Information</button></center>
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
