@extends('layouts.app')
{{-- page header --}}
@section('title','Products List')

{{-- content section --}}
@section('content')
   <!-- begin breadcrumb -->
   <div class="row mb-2">
      <div class="col-md-8">
         <h2 class="page-header"><i data-feather="list"></i> Products </h2>
      </div>
      <div class="col-md-4">
         <center>
            <a href="{!! route('products.create') !!}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Add New Products</a>
            <a href="{!! route('products.import') !!}" class="btn btn-warning btn-sm"><i class="fas fa-file-upload"></i> Import Products</a>
            {{-- <a href="{!! route('products.export','csv') !!}" class="btn btn-warning btn-sm"><i class="fas fa-file-download"></i> Export Products</a> --}}
         </center>
      </div>
   </div>
   <!-- end breadcrumb -->
   <!-- begin page-header -->

   <!-- end page-header -->
   @include('partials._messages')
   @livewire('products.products')
@endsection
