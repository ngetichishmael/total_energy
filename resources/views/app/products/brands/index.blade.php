@extends('layouts.app')
{{-- page header --}}
@section('title','Product Brands')
{{-- page styles --}}

{{-- content section --}}
@section('content')
@include('partials._messages')
<div class="content-header row">
   <div class="content-header-left col-md-12 col-12 mb-2">
      <div class="row breadcrumbs-top">
         <div class="col-12">
            <h2 class="content-header-title float-start mb-0">Brands</h2>
            <div class="breadcrumb-wrapper">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Products</a></li>
                  <li class="breadcrumb-item"><a href="#">Brands</a></li>
                  <li class="breadcrumb-item active"><a href="#">All</a></li>
               </ol>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- begin card -->
<div class="row">
   @livewire('brands.index')
   <div class="col-md-6">
      <div class="card card-default">
         <div class="card-body">
            <div class="card-body">
               <h4 class="card-title">Add brand</h4>
               {!! Form::open(array('route' => 'product.brand.store')) !!}
                  @csrf
                  <div class="form-group form-group-default required">
                     {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                     {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Brand Name','required' => '')) !!}
                  </div>
                  <div class="form-group mt-4">
                     <center>
                        <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Add brand</button>
                     </center>
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
