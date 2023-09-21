@extends('layouts.app1')
@section('title', 'Pending Deliveries')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Pending Deliveries </h2>
                </div>
            </div>
        </div>
    </div>
    @include('partials._messages')
    @livewire('orders.pendingdeliveries')
@endsection
