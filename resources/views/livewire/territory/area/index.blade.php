@extends('layouts.app1')
{{-- page header --}}
@section('title', 'Routes')
{{-- page styles --}}

{{-- content section --}}
@section('content')
    @include('partials._messages')
    <div class="content-header row">
        <div class="mb-2 content-header-left col-md-12 col-12">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="mb-0 content-header-title float-start">Routes</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Route</a></li>
                            <li class="breadcrumb-item active"><a href="#">All</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- begin card -->
    <div class="card">
    <h5 class="card-header"></h5>
    <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
        <div class="col-md-4 user_role">
            <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i data-feather="search"></i></span>
                </div>
                <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
            </div>
        </div>
        <div class="col-md-2 user_role">
            <div class="form-group">
                <label for="selectSmall">Per Page</label>
                <select wire:model="perPage" class="form-control form-control-sm" id="selectSmall">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <div class="col-md-2 d-flex justify-content-end">
   

            <div class="demo-inline-spacing">
           
            <button type="button" class="btn btn-icon btn-outline-success" wire:click="export"
                wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
                <img src="{{ asset('assets/img/excel.png') }}"alt="Export Excel" width="25" height="15"
                    data-toggle="tooltip" data-placement="top" title="Export Excel">Export
            </button>
          </div>


        </div>
    </div>
</div>
    <div class="row">
        @livewire('territory.area.dashboard')
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-body">
                    <div class="card-body">
                        <h4 class="card-title">Add Route </h4>
                        <form method="POST" action="{{ route('areas.store') }}" style="gap: 20px;">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="mb-2 col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="first-name-column">Route</label>
                                                        <input type="text" id="first-name-column" class="form-control"
                                                            placeholder="Route" name="name" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="select-country">Region</label>
                                                        <select class="form-control select2" id="select-country"
                                                            name="subregion" required>
                                                            <option value="">Select Regions</option>
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
                                <button type="submit" class="mb-1 mr-0 btn btn-success mb-sm-0 mr-sm-1"> Add Route</button>
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
