@extends('layouts.app')
{{-- page header --}}
@section('title','Product variants')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection


{{-- content section --}}
@section('content')
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Finance</a></li>
		<li class="breadcrumb-item"><a href="{!! route('finance.product.index') !!}">Products</a></li>
		<li class="breadcrumb-item active">Edit variants</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-boxes"></i> Product variants</h1>
	<!-- end page-header -->
	@include('partials._messages')
	<div class="row">
		@include('app.finance.partials._shop_menu')
		<div class="col-md-9">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Edit variants</h4>
            </div>
            <div class="panel-body">
               {!! Form::model($edit, ['route' => ['finance.products.variants.update',$edit->prodID], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'variant', array('class'=>'control-label')) !!}
                           {{ Form::select('variant',$values, null, ['class' => 'form-control', 'required' => '']) }}
                           <input type="hidden" name="attribute" value="{!! $product->attributeID !!}">
                           <input type="hidden" name="name" value="{!! $product->product_name !!}">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'SKU code', array('class'=>'control-label')) !!}
                           {!! Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'SKU code')) !!}
                        </div>
                     </div>
                     <div class="col-md-12"><hr></div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'Current Quantity', array('class'=>'control-label')) !!}
                           {!! Form::number('current_stock', null, array('class' => 'form-control', 'placeholder' => '0','required' => '','step' => '0.01')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'Re-order Point', array('class'=>'control-label')) !!}
                           {!! Form::number('reorder_level', null, array('class' => 'form-control', 'placeholder' => '0','step' => '0.01')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'Re-order Quantity:', array('class'=>'control-label')) !!}
                           {!! Form::number('replenish_level', null, array('class' => 'form-control', 'placeholder' => '0','step' => '0.01')) !!}
                        </div>
                     </div>
                     <div class="col-md-12"><hr></div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'Buying Price', array('class'=>'control-label')) !!}
                           {!! Form::number('buying_price', null, array('class' => 'form-control','placeholder' => 'Buying Price','step' => '0.01','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'Selling Price Per Unit', array('class'=>'control-label')) !!}
                           {!! Form::number('selling_price', null, array('class' => 'form-control', 'placeholder' => 'Selling Price','step' => '0.01','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'Offer Price Per Unit', array('class'=>'control-label')) !!}
                           {!! Form::number('offer_price', null, array('class' => 'form-control', 'placeholder' => 'Offer Price','step' => '0.01')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'Tax rule:', array('class'=>'control-label')) !!}
                           <select name="taxID" id="" class="form-control">
                              <option value=""> Choose tax</option>
                              @foreach($taxes as $tax)
                                 <option value="{!! $tax->id !!}">{!! $tax->name !!}-{!! $tax->rate !!}%</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-12"><hr></div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'Image', array('class'=>'control-label')) !!}
                           {!! Form::file('image', null, array('class' => 'form-control', 'placeholder' => 'Offer Price','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <center>
                           <button type="submit" class="btn btn-pink submit">Update changes</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
                        </center>
                     </div>
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
		</div>
	</div>
</div>
@endsection
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
   <script src="{!! asset('assets/plugins/jquery-tags-Input/src/jquery.tagsinput.js') !!}"></script>
@endsection

