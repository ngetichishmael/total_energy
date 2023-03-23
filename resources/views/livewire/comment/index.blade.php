@extends('layouts.app')
{{-- page header --}}
@section('title', 'Customer Comments')
{{-- page styles --}}
@section('stylesheets')

@endsection


{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->
    <div class="row mb-2">
        <div class="col-md-8">
            <h2 class="page-header">Customers Comments</h2>
        </div>
        =
    </div>

    @livewire('comment.dashboard')
@endsection=
