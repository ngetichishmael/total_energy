@extends('layouts.app')
{{-- page header --}}
@section('title', 'Leads Target')

{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->
    <div class="row mb-2">
        <div class="col-md-8">
            <h2 class="page-header"><i data-feather="list"></i> Sales Target </h2>
        </div>
    </div>
    <!-- end breadcrumb -->
    <!-- begin page-header -->

    <!-- end page-header -->
    @include('partials._messages')
    {{-- @livewire('products.products') --}}
    @livewire('target.dashboard')

@endsection
