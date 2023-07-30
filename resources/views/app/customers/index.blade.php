@extends('layouts.app1')

@section('title', 'Customer')

@section('content')
    <!-- begin breadcrumb -->
    <div class="row mb-2">
        <div class="col-md-8">
            <h2 class="page-header">Customers List</h2>
        </div>
      
    </div>
    <!-- end breadcrumb -->

    @livewire('customers.dashboard')


@endsection
