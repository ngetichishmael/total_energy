@extends('layouts.app')
{{-- page header --}}
@section('title','Add New Product')
@section('stylesheet')
   <style>
      ul.product li {
         width: 100%;
      }
   </style>
@endsection
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Products</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Products</a></li>
                     <li class="breadcrumb-item active">Create</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <!-- shop menu -->
      <div class="col-md-3">
         <div class="card card-white">
            <div class="card-body">
               <div class="nav flex-column nav-pills">
                  <a class="nav-link active" href="#">Information</a>
                  <a class="nav-link" href="#">Price</a>
                  <a class="nav-link" href="#">Inventory</a>
                </div>
            </div>
         </div>
      </div>
      <div class="col-md-9">
         <!-- end of shop menu -->
         {!! Form::open(array('route' => 'products.store', 'enctype'=>'multipart/form-data','method' => 'post','autocomplete' => 'off')) !!}
         {!! csrf_field() !!}
         <div class="card card-default">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group mb-1 form-group-default required">
                        {!! Form::label('title', 'Name', array('class'=>'control-label  text-danger')) !!}
                        {!! Form::text('product_name', null, array('class' => 'form-control', 'placeholder' => 'Enter Product Name','required' => '')) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group mb-1 form-group-default required ">
                        {!! Form::label('title', 'Status', array('class'=>'control-label')) !!}
                        {{ Form::select('status',['Active'=>'Active','No'=>'No'], null, ['class' => 'form-control', 'required' => '']) }}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group mb-1 form-group-default">
                        {!! Form::label('title', 'SKU code', array('class'=>'control-label')) !!}
                        {!! Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'SKU code')) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group mb-1 form-group-default">
                        {!! Form::label('title', 'Brand', array('class'=>'control-label')) !!}
                        <select name="brandID" id="brandID" class="form-control">
			<option value="">-- Please choose an option--</option>
			@foreach($brands as $brand)
				<option value='{{ $brand }}'>{{$brand}}</option>
			@endforeach
			</select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group mb-1 form-group-default">
                        {!! Form::label('title', 'Supplier', array('class'=>'control-label')) !!}
                        {!! Form::select('supplierID',$suppliers,null,['class' => 'form-control multiselect']) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group mb-1 form-group-default">
                        {!! Form::label('title', 'Product category', array('class'=>'control-label')) !!}

			<select name="category" id="category" class="form-control">
    			<option value="">--Please choose an option--</option>
    			@foreach($categories as $category)
				<option value='{{ $category }}'>{{$category}}</option>
			@endforeach
			</select>	
                     </div>
                  </div>
                  <div class="col-md-12 mt-2">
                     <center>
                        <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Add Product</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
                     </center>
                  </div>
               </div>
            </div>
         </div>
         {!! Form::close() !!}
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')
	<script>
      $(document).ready(function() {
         $('#sku').on('change', function() {
            if (this.value == 'Custom') {
               $('#custom-sku').show();
            }
            if (this.value == 'Auto') {
               $('#custom-sku').hide();
            }
         });
      });
   </script>
@endsection
