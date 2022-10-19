@extends('layouts.app')
{{-- page header --}}
@section('title','Sales Target')

{{-- content section --}}
@section('content')
   <!-- begin breadcrumb -->
   <div class="row mb-2">
      <div class="col-md-8">
         <h2 class="page-header"><i data-feather="list"></i> Sales </h2>
      </div>
      <div class="col-md-4">
         <center>
            <a href="{!! route('products.create') !!}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> New Target</a>
         </center>
      </div>
   </div>
   <!-- end breadcrumb -->
   <!-- begin page-header -->

   <!-- end page-header -->
   @include('partials._messages')
   @livewire('target.sales')
@endsection
