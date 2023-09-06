@extends('layouts.app')
{{-- page header --}}
@section('title', 'Users')

{{-- content section --}}
@section('content')
    @livewire('users.user-types')
@endsection
{{-- page scripts --}}
@section('script')

@endsection
