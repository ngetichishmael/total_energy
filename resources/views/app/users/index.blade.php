@extends('layouts.app')
{{-- page header --}}
@section('title','Users')

{{-- content section --}}
@section('content')
   <!-- begin breadcrumb -->
   <div class="row mb-2">
      <div class="col-md-9">
         <h2 class="page-header"> Users </h2>
      </div>
      <div class="col-md-3">
         <center>
            <a href="{!! route('user.create') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Add Users</a>
         </center>
      </div>
   </div>
   <!-- end breadcrumb -->
   @livewire('users.index')
@endsection
{{-- page scripts --}}
@section('script')

@endsection
