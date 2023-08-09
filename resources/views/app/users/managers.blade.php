@extends('layouts.app1')
{{-- page header --}}
@section('title', 'Distributors')

{{-- content section --}}
@section('content')
@if(Auth::check() && Auth::user()->account_type == 'Admin')
    <!-- begin breadcrumb -->
     <!-- begin breadcrumb -->
     <div class="mb-2 row">
        <div class="col-md-9">
            <h2 class="page-header"> Managers </h2>
        </div>
        <div class="col-md-3">
            <center>
                <!-- <a href="{!! route('user.create') !!}" class="btn btn-sm" style="background-color: #027333;color:white"><i data-feather="user-plus"></i> Add </a> -->

                {{-- <a href="{!! route('users.all.import') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Import</a> --}}
            </center>
        </div>
    </div>
    <!-- end breadcrumb -->
    @livewire('users.managers')

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
@section('script')

@endsection
