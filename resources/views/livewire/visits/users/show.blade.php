@extends('layouts.app1')
{{-- page header --}}
@section('title', 'Visits by ' . $name)

{{-- content section --}}
@section('content')
    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start">Visits by {{ $name }}</h2>
                
                </div>
            </div>
        </div>
    </div>
    @include('partials._messages')
    @livewire('visits.users.view', [
        'user_code' => $user_code,
    ])
@endsection
{{-- page scripts --}}
