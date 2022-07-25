@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Product')
@section('stylesheet')
	<style>
      ul.product li {
         width: 100%;
      }
   </style>
@endsection

{{-- content section --}}
@section('content')
   <!-- begin page-header -->
   <h3 class="page-header"> Edit Products</h3>
   <!-- end page-header -->
   <div class="row">
      @include('app.products._product_menu')
      <div class="col-md-9">
         {!! Form::model($product, ['route' => ['products.update',$product->productID], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!}
            {!! csrf_field() !!}
            <div class="card card-default">
               <div class="card-body">
                  <div class="row">

                     <div class="col-md-6">
                        <div class="form-group mb-1 form-group-default required">
                           {!! Form::label('title', 'Name', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('product_name', null, array('class' => 'form-control', 'placeholder' => 'Enter Product Name','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group mb-1 form-group-default required ">
                           {!! Form::label('title', 'Status', array('class'=>'control-label text-danger')) !!}
                           {{ Form::select('status',['Active'=>'Active'], null, ['class' => 'form-control multiselect', 'required' => '']) }}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group mb-1 form-group-default required">
                           {!! Form::label('title', 'SKU code', array('class'=>'control-label')) !!}
                           {!! Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'SKU code', 'required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group mb-1 form-group-default">
                           {!! Form::label('title', 'Brand', array('class'=>'control-label')) !!}
                           <select name="brandID" id="brandID" class="form-control">
				@foreach ($brands as $brand)
					<option value='{{ $brand }}' {{ ($brand == $product->productName) ? 'selected' : '' }}> {{ $brand }} </option>
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
                           <div class="form-group mb-1 required form-group-default">
                              {!! Form::label('title', 'Product category', array('class'=>'control-label')) !!}
                              {{ Form::select('category',$category,null,['class' => 'form-control']) }}
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group mb-1 mt-3">
                              <center>
                                 <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Item</button>
                                 <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
                              </center>
                           </div>
                        </div>
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

@endsection
