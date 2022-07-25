@extends('layouts.app')
{{-- page header --}}
@section('title','New Customer')
{{-- page styles --}}


{{-- content section --}}
@section('content')
   <!-- begin breadcrumb -->
   <div class="row mb-2">
      <div class="col-md-8">
         <h2 class="page-header"><i data-feather="users"></i> Customers </h2>
      </div>
      <div class="col-md-4">


      </div>
   </div>
   <!-- end breadcrumb -->
	{!! Form::open(array('route' => 'customer.store','class'=>'row','enctype'=>'multipart/form-data','method'=>'post' )) !!}
      {!! csrf_field() !!}
      <div class="col-md-8">
         <div class="card card-default">
            <div class="card-body">
               <div class="row">
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('customer_name', 'Customer names', array('class'=>'control-label')) !!}
                     {!! Form::text('customer_name', null, array('class' => 'form-control', 'placeholder' => 'Enter customer name')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('caccount', 'Account Number', array('class'=>'control-label')) !!}
                     {!! Form::text('account', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('manufacturer_number', 'Manufacturer number', array('class'=>'control-label')) !!}
                     {!! Form::text('manufacturer_number', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('vat_number', 'VAT number', array('class'=>'control-label')) !!}
                     {!! Form::text('vat_number', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('delivery_time', 'Delivery time', array('class'=>'control-label')) !!}
                     <input type="time" class="form-control" name="delivery_time">
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('address', 'Address', array('class'=>'control-label')) !!}
                     {!! Form::text('address', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('city', 'City', array('class'=>'control-label')) !!}
                     {!! Form::text('city', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('province', 'Province', array('class'=>'control-label')) !!}
                     {!! Form::text('province', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('postal_code', 'Postal code', array('class'=>'control-label')) !!}
                     {!! Form::text('postal_code', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('country', 'Country', array('class'=>'control-label')) !!}
                     {!! Form::text('country', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('latitude', 'Latitude', array('class'=>'control-label')) !!}
                     {!! Form::text('latitude', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('longitude', 'Longitude', array('class'=>'control-label')) !!}
                     {!! Form::text('longitude', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('contact_person', 'Contact person	', array('class'=>'control-label')) !!}
                     {!! Form::text('contact_person', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('telephone', 'Telephone', array('class'=>'control-label')) !!}
                     {!! Form::text('telephone', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('customer_group', 'Customer group', array('class'=>'control-label')) !!}
                     {!! Form::text('customer_group', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('customer_secondary_group', 'Customer secondary group', array('class'=>'control-label')) !!}
                     {!! Form::text('customer_secondary_group', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('price_group', 'Price group', array('class'=>'control-label')) !!}
                     {!! Form::text('price_group', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('route', 'Route', array('class'=>'control-label')) !!}
                     {!! Form::text('route', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('branch', 'Branch', array('class'=>'control-label')) !!}
                     {!! Form::text('branch', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('email', 'Email', array('class'=>'control-label')) !!}
                     {!! Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('phone_number', 'Phone number', array('class'=>'control-label')) !!}
                     {!! Form::text('phone_number', null, array('class' => 'form-control', 'placeholder' => 'Enter value')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('zone', 'Zone', array('class'=>'control-label')) !!}
                     {!! Form::select('zone',[],null, array('class' => 'form-control')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('Region', 'Region', array('class'=>'control-label')) !!}
                     {!! Form::select('region',[], null, array('class' => 'form-control')) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     {!! Form::label('Territory', 'Territory', array('class'=>'control-label')) !!}
                     {!! Form::select('territory',[],null, array('class' => 'form-control')) !!}
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
