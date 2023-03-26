@extends('layouts.app')
{{-- page header --}}
@section('title', 'Customers Visits')

{{-- content section --}}
@section('content')
    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start">Customers Visits</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{!! route('customer') !!}">Customers</a></li>
                            <li class="breadcrumb-item active">List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials._messages')
    @livewire('visits.customer.dashboard')
@endsection
{{-- page scripts --}}
