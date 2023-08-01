@extends('layouts.app1')
{{-- page header --}}
@section('title', 'Pending Delivery')

{{-- content section --}}
@section('content')
    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start">Pending Payment </h2>
                    <!-- <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="sokoflowadmin">Home</a></li>
                            <li class="breadcrumb-item"><a href="{!! route('delivery.index') !!}">Pending Payment</a></li>
                            <li class="breadcrumb-item active">List</li>
                        </ol>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    @include('partials._messages')
    @livewire('payment.pending.dashboard')
@endsection
{{-- page scripts --}}
