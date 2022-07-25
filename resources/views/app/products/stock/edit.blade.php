@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Purchase Order')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.lpo.index') !!}">Stock control</a></li>
         <li class="breadcrumb-item active">Edit Purchase Order</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-file-contract"></i> Edit Purchase Order</h1>
      @include('partials._messages')
      {!! Form::model($lpo, ['route' => ['finance.product.stock.order.update',$lpo->id], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
         @csrf 
         <div class='row'>
            <div class="col-md-4 col-lg-4"> 
               <div class="form-group form-group-default">
                  <label for="client" class="text-danger">Suppliers *</label>
                  <select name="supplier" class="form-control default-select2 multiselect" required>
                     <option selected value="{{ $lpo->supplierID }}">{!! $supplier->supplierName !!}</option>
                     <option value=""><b>Choose supplier</b></option>
                     @foreach ($suppliers as $cli)
                        <option value="{{ $cli->id }}">
                           {!! $cli->supplierName !!}
                        </option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group">
                  <label for="number">LPO Number</label>
                  <div class="input-group">
                     <span class="input-group-addon solso-pre">{{ Finance::lpo()->prefix }}</span>
                     {!! Form::text('lpo_number', null, array('class' => 'form-control equired no-line', 'autocomplete' => 'off', 'placeholder' => '','readonly' => '')) !!}
                  </div>
                  <?php echo $errors->first('number', '<p class="error">:messages</p>');?>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number" class="">Reference # </label>
                  <div class="input-group">
                     {{ Form::text('reference_number',null, ['class' => 'form-control','placeholder' => 'Enter reference number']) }}
                  </div>
               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                   <label for="title">Title</label>
                   {!! Form::text('title',null,['class' => 'form-control', 'required' => '', 'placeholder' => 'Enter title']) !!}
               </div>
           </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="date" class="text-danger">Date Create *</label>
                  {!! Form::text('lpo_date', null, array('class' => 'form-control datepicker required', 'placeholder' => 'Enter date','required' => '')) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end" class="text-danger">Delivery due * </label>
                  {!! Form::text('lpo_due', null, array('class' => 'form-control datepicker-rs required', 'placeholder' => 'Enter date','required' => '')) !!}
               </div>
            </div>
         </div>
         <div class="load-animate">
            <div class='row mt-3'>
               <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                  <table class="table table-bordered table-striped" id="table">
                     <thead>
                        <tr>
                           <th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
                           <th width="38%">Item Name</th>
                           <th width="15%">Supply Price</th>
                           <th width="15%">Quantity</th>
                           <th width="15%">Total</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($lpoproducts as $product)
                           <tr id="tr_1">
                              <td><input class="case" type="checkbox"/></td>
                              <td>
                                 <select name="productID[]" class="form-control solsoCloneSelect2" id="itemName_1" data-init-plugin='select2' required>
                                    <option value="{{ $product->productID }}">
                                       @if(Finance::check_product($product->productID) == 1)
                                          {!! Finance::product($product->productID)->product_name !!}
                                       @else
                                          <i>Unknown Product</i>
                                       @endif
                                    </option>
                                    @foreach ($products as $prod)
                                       <option value="{{ $prod->id }}"> {!! $prod->product_name !!} </option>
                                    @endforeach
                                 </select>
                                 <?php echo $errors->first('currency', '<p class="error">:messages</p>');?>
                              </td>
                              <td>
                                 <input type="number" name="price[]" id="price_1" value="{{ $product->price }}" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                              </td>
                              <td>
                                 <input type="number" name="qty[]" id="quantity_1" value="{{ $product->quantity }}" class="form-control changesNo quanyityChange" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                              </td>
                              <td>
                                 <input type="number" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" value="<?php echo $product->price * $product->quantity ?>">
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                     <tfoot>
                        <tr class="table-default">
                           <td colspan="2" class="col-md-12 col-lg-8"></td>
                           <td colspan="2" style="width:20%">
                              <h4 class="pull-right top10">Total Amount</h4>
                           </td>
                           <td colspan="2">
                              <h4 class="text-center">
                                 <input readonly value="{!! $lpo->total !!}" type="number" class="form-control" name="data[Invoice][invoice_total]" id="totalAftertax" placeholder="Total" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                              </h4>
                           </td>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
            <div class='row mb-3'>
               <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                  <button class="btn btn-danger delete" type="button">- Delete</button>
                  <button class="btn btn-primary addmore" type="button">+ Add More</button>
               </div>
            </div>
            <div class='form-group text-center'>
                  <center>
                     <button type="submit"class="btn btn-pink btn-lg submit"><i class="fas fa-save"></i> Update order </button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
                  </center>
               </div>
            </div>
         </div>
      {{ Form::close() }}
   </div>
@endsection
@include('app.finance.partials._lpo')
