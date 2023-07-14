@extends('layouts.app')
{{-- page header --}}
@section('title', 'Users')

{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->
    <div class="mb-2 row">
        <div class="col-md-9">
            <h2 class="page-header"> Users </h2>
        </div>
        <div class="col-md-3">
            <center>
                <a href="{!! route('user.create') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Add Users</a>
                {{-- <a href="{!! route('users.all.import') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Import</a> --}}
            </center>
        </div>
    </div>
    <!-- end breadcrumb -->
    @livewire('users.index')
@endsection
{{-- page scripts --}}
@section('script')

@endsection
