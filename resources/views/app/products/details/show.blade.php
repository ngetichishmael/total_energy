@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $details->product_name !!} | Items  @endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.partials._menu')
@endsection


{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <a href="{{ route('products.edit', $details->proID) }}"  class="btn btn-primary ml-1"><i class="fal fa-pen-fancy"></i></a>
      <a href="{!! route('products.destroy', $details->proID) !!}" class="btn btn-danger ml-1 delete">Delete</a>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header">{!! $details->product_name !!}</h1>
   <div class="row">
      <div class="col-md-12">
         <ul class="nav nav-tabs">
            <li class="nav-item {!! Nav::isRoute('products.details') !!}">
               <a class="nav-link {!! Nav::isRoute('products.details') !!}" href="#"><i class="fal fa-info-circle"></i> Overview</a>
            </li>
            {{-- <li class="nav-item">
               <a class="nav-link {!! Nav::isRoute('subscriptions.invoices') !!}" href="#"><i class="fal fa-file-invoice-dollar"></i> Invoice History</a>
            </li> --}}
         </ul>
      </div>
      @if(Request::is('finance/items/'.$details->proID.'/details'))
         @include('app.products.details.overview')
      @endif
   </div>
</div>
@endsection
{{-- page scripts --}}
