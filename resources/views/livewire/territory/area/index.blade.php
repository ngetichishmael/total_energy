@extends('layouts.app')
{{-- page header --}}
@section('title', 'Product Brands')
{{-- page styles --}}

{{-- content section --}}
@section('content')
    @include('partials._messages')
    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start">Areas</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Areas</a></li>
                            <li class="breadcrumb-item active"><a href="#">All</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- begin card -->
    <div class="row">
        @livewire('territory.area.dashboard')
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-body">
                    <div class="card-body">
                        <h4 class="card-title">Add Area </h4>
                        <form method="POST" action="{{ route('areas.store') }}" style="gap: 20px;">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="mb-2 col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="first-name-column">Area</label>
                                                        <input type="text" id="first-name-column" class="form-control"
                                                            placeholder="Area" name="name" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="select-country">Sub Region</label>
                                                        <select class="form-control select2" id="select-country"
                                                            name="subregion" required>
                                                            <option value="">Select Subregion</option>
                                                            @foreach ($subregions as $subregion)
                                                                <option value="{{ $subregion->id }}">{{ $subregion->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 col-12 d-flex flex-sm-row flex-column" style="gap: 20px;">
                                <button type="submit" class="mb-1 mr-0 btn btn-success mb-sm-0 mr-sm-1"> Add Area</button>
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