@extends('layouts.app1')
{{-- page header --}}
@section('title', 'Customer')
{{-- page styles --}}
@section('stylesheets')

@endsection


{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->
    <div class="row mb-2">
        <div class="col-md-8">
            <h2 class="page-header">Customers List</h2>
        </div>
        <div class="col-md-4">
            <center>
                <!-- <a href="{!! route('customer.create') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Add a
                    Customer</a>
                <a href="{{ route('user-import') }}" class="btn btn-info btn-sm"><i class="fa fa-file-upload"></i> Import
                    Customer</a> -->
                {{-- <a href="{!! route('customer.export','csv') !!}" class="btn btn-warning btn-sm"><i class="fal fa-file-download"></i> Export Customer</a> --}}
                
            </center>
        </div>
    </div>
    <!-- end breadcrumb -->

    @livewire('customers.dashboard')
    <br>
@endsection

