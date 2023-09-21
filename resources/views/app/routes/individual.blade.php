@extends('layouts.app')
{{-- page header --}}
@section('title','Route List')

{{-- content section --}}
@section('content')
   <div class="row mb-2">
      <div class="col-md-8">
         <h2 class="page-header"> Individual Route</h2>
      </div>
      {{-- <div class="col-md-4">
         <center>
            <a href="{!! route('routes.create') !!}" class="btn btn-sm" style="background-color: #B6121B;color:white"><i data-feather="plus"></i> Add Route</a>
         </center>
      </div> --}}
   </div>
   @include('partials._messages')
   @livewire('routes.individual')
@endsection
{{-- page scripts --}}
@section('script')

@endsection
