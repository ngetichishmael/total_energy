@extends('layouts.app')
{{-- page header --}}
@section('title', 'Survery Responses')

{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->
    <div class="mb-2 row">
        <div class="col-md-9">
            <h2 class="page-header"> Responses </h2>
        </div>
        <div class="col-md-3">

        </div>
    </div>
    <!-- end breadcrumb -->
    @livewire('survery.responses.dashboard')
@endsection
{{-- page scripts --}}
@section('script')

@endsection
