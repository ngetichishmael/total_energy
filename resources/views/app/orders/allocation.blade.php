@extends('layouts.app')

@section('stylesheets')

@endsection
{{-- page header --}}
@section('title','Order Assign')

{{-- content section --}}
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Order Details | Assign Order</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Orders</a></li>
                     <li class="breadcrumb-item active">{!! $order->order_code !!}</li>
                     <li class="breadcrumb-item active">Assign Order</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   @include('partials._messages')
   <form class="row" action="{!! route('order.create.delivery') !!}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="order_code" value="{!! $order->order_code !!}">
      <input type="hidden" name="customer" value="{!! $order->customerID !!}">
      <div class="col-md-8">
         <div class="card">
            <div class="card-body">
               <h4>Assign Order To User</h4>
               <hr>
               <div class="row">
                  <div class="form-group col-md-6">
                     <label for="">Choose User</label>
                     <select name="user" class="form-control" required>
                        <option value="">Choose User</option>
                        @foreach($users as $user)
                           <option value="{!! $user->user_code !!}">{!! $user->name !!}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="">Assign Stock From</label>
                     <select name="warehouse" class="form-control" required>
                        <option value="">Choose warehouse</option>
                        @foreach($warehouses as $warehouse)
                           <option value="{!! $warehouse->warehouse_code !!}">{!! $warehouse->name !!}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
         </div>
         <div class="card mt-2">
            <div class="card-body">
               <h4>Assign Items</h4>
               <hr>
               @foreach($items as $item)
                  <input type="hidden" name="item_code[]" value="{!! $item->productID !!}">
                  <div class="row mb-1">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="">Product</label>
                           <input type="text" value="{!! $item->product_name !!}" class="form-control" readonly>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="">Quantity</label>
                           <input type="text" value="{!! $item->quantity !!}" class="form-control" readonly>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="">Allocate</label>
                           <input type="text" name="allocate[]" class="form-control" placeholder="max {!! $item->quantity !!}" max="{!! $item->quantity !!}">
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
         </div>
         <button class="btn btn-success mt-1" type="submit">Save and Allocate order</button>
      </div>
   </form>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
