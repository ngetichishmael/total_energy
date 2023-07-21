@extends('layouts.app')
{{-- page header --}}
@section('title', 'Product Brands')
{{-- page styles --}}

{{-- content section --}}
@section('content')
@if(Auth::check() && Auth::user()->account_type == 'Admin')
    @include('partials._messages')
    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start">Brands</h2>
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
                        {!! Form::open(['route' => 'product.brand.store']) !!}
                        @csrf
                        <div class="form-group form-group-default required">
                            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Brand Name', 'required' => '']) !!}
                        </div>
                        <div class="mt-4 form-group">
                            <center>
                                <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Add
                                    brand</button>
                            </center>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
   <div class="misc-inner p-2 p-sm-3">
            <div class="w-100 text-center">
                <h2 class="mb-1">You are not authorized! 🔐</h2>
                <p class="mb-2">Sorry, but you do not have the necessary permissions to access this page.</p>
                <img class="img-fluid" src="{{asset('images/pages/not-authorized.svg')}}" alt="Not authorized page" />
            </div>
        </div>
   @endif
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
