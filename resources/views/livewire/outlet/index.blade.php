@extends('layouts.app1')
{{-- page header --}}
@section('title', 'Customer Outlets')
{{-- page styles --}}
@php
    use Illuminate\Support\Str;
@endphp
{{-- content section --}}
@section('content')
    @include('partials._messages')
    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start">Outlets</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">outlets</a></li>
                            <li class="breadcrumb-item active"><a href="#">All</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- begin card -->
    <div class="row">
        @livewire('outlet.dashboard')
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-body">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Add Outlet</h4> -->

                        <form class="form" method="POST" action="{{ route('outlets.store') }}">
                            @method('POST')
                            @csrf
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="outlet_code">Outlet Name</label>
                                    <input type="text" id="outlet_name" class="form-control" placeholder="Outlet Name"
                                        name="outlet_name" required />
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <input type="text" id="outlet_code" class="form-control"
                                        value="{{ str::random(20) }}" name="outlet_code" hidden readonly />
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <input type="text" id="business_code" class="form-control"
                                        value="{{ Auth::user()->business_code }}" name="business_code" hidden readonly />
                                </div>
                            </div>

                            <div class="my-1 col-sm-9 offset-sm-3">
                                <button type="submit" class="mr-1 btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
