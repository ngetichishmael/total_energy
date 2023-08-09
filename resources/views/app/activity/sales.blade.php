@extends('layouts.app3')
{{-- page header --}}
@section('title', 'Sales Logs')
{{-- page styles --}}
@section('stylesheets')

@endsection


{{-- content section --}}
@section('content')
    <!-- Dashboard Ecommerce Starts -->
    @livewire('activity.sales')
    <!-- Dashboard Ecommerce ends -->
@endsection
{{-- page scripts --}}
@section('script')

@endsection

