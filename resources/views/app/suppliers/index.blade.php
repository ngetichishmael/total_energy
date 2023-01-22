@extends('layouts.app')
{{-- page header --}}
@section('title', 'Supplier List')

{{-- content section --}}
@section('content')
    <div class="row mb-2">
        <div class="col-md-8">
            <h2 class="page-header"> Supplier</h2>
        </div>
        <div class="col-md-4">
            <center>
                <a href="{!! route('supplier.create') !!}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Add Supplier</a>
            </center>
        </div>
    </div>
    @include('partials._messages')
    @livewire('supplier.dashboard')
@endsection
{{-- page scripts --}}
@section('script')

@endsection
