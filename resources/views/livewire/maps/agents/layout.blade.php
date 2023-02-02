@extends('layouts.app')
{{-- page header --}}
@section('title', 'Sales Agents')

{{-- content section --}}
@section('content')

    @livewire('maps.agents.dashboard')

@endsection
