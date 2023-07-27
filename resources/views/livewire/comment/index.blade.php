@extends('layouts.app1')

@section('title', 'Customer Comments')

@section('content')

    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start"> Customers Comments </h2>
                
                </div>
            </div>
        </div>
    </div>

    @livewire('comment.dashboard')
@endsection
