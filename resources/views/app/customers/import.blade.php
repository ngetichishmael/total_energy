@extends('layouts.app')
{{-- page header --}}
@section('title', 'Import Customer')


{{-- content section --}}
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <h4>Upload Customer</h4>
                        <div class="col-md-4 mtop15">
                            <form action="{{ route('user-import.store') }}" id="import_form" enctype="multipart/form-data"
                                method="post" accept-charset="utf-8">
                                @csrf
                                <input type="hidden" name="clients_import" value="true">
                                <div class="form-group mb-2 form-group-default">
                                    <label for="file_csv" class="control-label  text-danger">
                                        <small class="req text-danger">* </small>Choose CSV File
                                    </label>
                                    <input type="file" name="upload_import" required />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success submit">Import</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
