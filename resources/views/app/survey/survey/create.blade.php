@extends('layouts.app')
@section('title', 'Add Survey')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Survey</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Survey</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials._messages')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('survey.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="form-group mb-1">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Title" required>
                        </div>
                        <div class="form-group mb-1">
                            <label for="type" class="control-label">Type</label>
                            <select name="type" class="form-control" required>
                                <option value="online">Online</option>
                            </select>
                        </div>
                    </div>
                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="form-group mb-1">
                            <label for="visibility" class="control-label">Visibility</label>
                            <select name="visibility" class="form-control">
                                <option value="Public">Public</option>
                                <option value="Private">Private</option>
                            </select>
                        </div>
                        <div class="form-group mb-1">
                            <label for="status" class="control-label">Category Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Active">Active</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>
                    </div>
                    <!-- Date Fields -->
                    <div class="col-md-12 mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">End Date</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Description -->
                    <div class="col-md-12 mb-1">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control my-editor" rows="6" placeholder="caption"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <center>
                                <button type="submit" class="btn btn-success btn-sm submit">Add Survey</button>
                                <img src="{{ asset('assets/images/loader.gif') }}" alt="" class="submit-load"
                                    style="width: 10%">
                            </center>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
