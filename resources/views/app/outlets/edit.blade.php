@extends('layouts.app')
{{-- page header --}}
@section('title', 'Outlet Edit')
{{-- page styles --}}

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
                            <li class="breadcrumb-item"><a href="#">Edit Outlet</a></li>
                            <li class="breadcrumb-item active"><a href="#">All</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- begin card -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-body">
                    <div class="card-body">
                        <h4 class="card-title">Update Outlet</h4>

                        <form class="form" method="POST" action="{{ route('outlets.update',$edit->id) }}">
                            
                            @csrf
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="outlet_code">Outlet Name</label>
                                    <input type="text" id="outlet_name" class="form-control" value="{{ $edit->outlet_name }}"
                                        name="outlet_name" required />
                                </div>
                            </div>

                            <div class="my-1 col-sm-9 offset-sm-3">
                                <button type="submit" class="mr-1 btn btn-primary">Update</button>
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
