@extends('layouts.app')
{{-- page header --}}
@section('title', 'Route Scheduling')
{{-- page styles --}}

{{-- content section --}}
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Route Scheduling</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Route</a></li>
                            <li class="breadcrumb-item active">Scheduling</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('routes.store') }}" method="post" class="row" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-12 mb-1">
                            <label for="name">Routes</label>
                            <select name="name[]" class="form-control select2" multiple>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone }}">{{ $zone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mb-1">
                            <div class="form-group col-md-4">
                                <label for="start_date">Start Date</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="end_date">End Date</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="">Choose status</option>
                                    <option value="Active">Active</option>
                                    <option value="Close">Close</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mb-1">
                            <label for="customers">Add Customer to Route</label>
                            <select name="customers[]" class="form-control select2" multiple>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer }}">{{ $customer }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12 mb-1">
                            <label for="sales_persons">Add sales people to Route</label>
                            <select name="sales_persons[]" class="form-control select2" multiple>
                                @foreach ($salesPeople as $salesPerson)
                                    <option value="{{ $salesPerson }}">{{ $salesPerson }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-1">
                            <button class="btn btn-success" type="submit">Save Information</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
