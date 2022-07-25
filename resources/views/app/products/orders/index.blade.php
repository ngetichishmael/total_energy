@extends('layouts.app')
{{-- page header --}}
@section('title','All Orders')
{{-- page styles --}}

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
         <li class="breadcrumb-item"><a href="{!! route('finance.product.index') !!}">Items</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.product.index') !!}">e-Commerce</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.ecommerce.orders') !!}">Orders</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">e-Commerce</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-12">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="1%">#</th>
                              <th>OrderID</th>
                              <th>Cusomer</th>
                              <th>Total</th>
                              <th>Payment Type</th>
                              <th>Delivery Status</th>
                              <th>Payment Status</th>
                              <th>Order date</th>
                              <th width="10%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($orders as $order)
                              <tr>
                                 <td>{!! $count++ !!}</td>
                                 <td>{!! $order->serialNo !!}</td>
                                 <td>{!! $order->customer_name !!}</td>
                                 <td>{!! $order->code !!} {!! number_format($order->total) !!}</td>
                                 <td>{!! $order->gateway_name !!}</td>
                                 <td><span class="badge {!! Limitless::status($order->delivery_status)->name !!}">{!! Limitless::status($order->delivery_status)->name !!}</span></td>
                                 <td><span class="badge {!! Limitless::status($order->payment_status)->name !!}">{!! Limitless::status($order->payment_status)->name !!}</span></td>
                                 <td>{!! date('jS F, Y', strtotime($order->order_date)) !!}</td>
                                 <td><a href="{!! route('finance.ecommerce.orders.view',$order->orderID) !!}" class="btn btn-pink btn-sm"><i class="fas fa-eye"></i> view order</a></td>
                              </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
