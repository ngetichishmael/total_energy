@extends('layouts.app')
{{-- page header --}}
@section('title', 'Map')

{{-- content section --}}
@section('content')

   @livewire('maps.dashboard')
   <br>
@endsection
