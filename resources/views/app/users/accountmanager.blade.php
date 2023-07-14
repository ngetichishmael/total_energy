@extends('layouts.app3')
{{-- page header --}}
@section('title', 'Account Manager')

{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->
    <div class="mb-2 row">
        <div class="col-md-9">
            <h2 class="page-header"> Account Managers</h2>
        </div>
        <div class="col-md-3">
            <center>

                {{-- <a href="{!! route('users.all.import') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Import</a> --}}
            </center>
        </div>
    </div>
    <!-- end breadcrumb -->
    @livewire('users.account-manager')
@endsection
{{-- page scripts --}}
@section('script')
@endsection
