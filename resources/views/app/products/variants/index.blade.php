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
               <h4 class="panel-title">Product variants</h4>
            </div>
            <div class="panel-body">
               <div class="row mb-2">
                  <div class="col-md-12">
                     <a href="" class="btn btn-pink float-right" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus"></i> Add Variable</a>
                  </div>
               </div>
               <table class="table table-bordered table-striped">
                  <thead>
                     <th width="1%">#</th>
                     <th width="5%"></th>
                     <th>variant</th>
                     <th>Selling price</th>
                     <th>quantity</th>
                     <th width="16%">Action</th>
                  </thead>
                  <tbody>
                     @foreach ($variants as $variant)
                        <tr>
                           <td>{!! $count++ !!}</td>
                           <td>
                              <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/finance/products/'.Finance::product_image($variant->prodID)->file_name) !!}" width="80px" height="60px">
                           </td>
                           <td>{!! $variant->value !!}</td>
                           <td>{!! $variant->selling_price !!} {!! $currency->code !!}</td>
                           <td>{!! $variant->current_stock !!}</td>
                           <td>
                              <a href="{!! route('finance.products.variants.edit',[$productID,$variant->prodID]) !!}" class="btn btn-primary btn-sm">Edit</a>
                              <a href="{!! route('finance.products.destroy',$variant->prodID) !!}" class="btn btn-sm btn-danger">Delete</a>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
		</div>
	</div>
</div>
<!-- Modal -->
<form action="{!! route('finance.products.variants.store',$productID) !!}" method="post" enctype="multipart/form-data">
   <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalCenterTitle">Add variant</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
               @csrf
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
                        {{ Form::select('code_type',['Auto'=>'Automatically Generate a SKU','Custom'=>'Enter a custom SKU'], null, ['class' => 'form-control', 'required' => '', 'id' => 'sku']) }}
                     </div>
                  </div>
                  <div class="col-md-6" style="display:none;" id="custom-sku">
                     <div class="form-group form-group-default">
                           {!! Form::label('title', 'SKU code', array('class'=>'control-label')) !!}
                           {!! Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'SKU code')) !!}
                     </div>
                  </div>
                  <div class="col-md-12">
                     <hr>
                  </div>
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
                  <div class="col-md-12">
                     <hr>
                  </div>
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
                  <div class="col-md-12">
                     <hr>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('title', 'Image', array('class'=>'control-label')) !!}
                        {!! Form::file('image', null, array('class' => 'form-control', 'placeholder' => 'Offer Price','required' => '')) !!}
                     </div>
                  </div>
               </div>                
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-pink submit">Save changes</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
            </div>
         </div>
      </div>
   </div>
</form>
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

