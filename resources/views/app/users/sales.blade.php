@extends('layouts.app')
{{-- page header --}}
@section('title', 'Sales Agents')

{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->
    <div class="mb-2 row">
        <div class="col-md-9">
            <h2 class="page-header"> Sales</h2>
        </div>
        <div class="col-md-3">
            <center>
                <!-- <a href="{!! route('user.create') !!}" class="btn btn-sm" style="background-color: #027333;color:white"><i data-feather="user-plus"></i> Add </a> -->

                {{-- <a href="{!! route('users.all.import') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Import</a> --}}
            </center>
        </div>
    </div>
    <!-- end breadcrumb -->
    @livewire('users.sales')
@endsection
{{-- page scripts --}}
@section('script')

@endsection
