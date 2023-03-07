@extends('layouts.app')
{{-- page header --}}
@section('title', 'Survery Responses')

{{-- content section --}}
@section('content')
    <!-- begin breadcrumb -->
    <div class="mb-2 row">
        <div class="col-md-9">
            <h2 class="page-header"> Responses </h2>
        </div>
        <div class="col-md-3">

        </div>
    </div>
    <!-- end breadcrumb -->
    <section class="counter-textarea">
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Response View</h4>
                    </div>
                    <div class="card-body">
                        <div class="my-1 form-group">
                            <label for="disabledInput">Customer Name</label>
                            <input type="text" class="form-control" id="readonlyInput" readonly="readonly"
                                value="{{ $response->Customer->customer_name }}" />
                        </div>
                        <div class="my-1 row">
                            <div class="col-12">
                                <div class="mb-0 form-label-group">
                                    <label for="textarea-counter">Survery Description</label>
                                    <textarea data-length="10" class="form-control char-textarea" id="textarea-counter" rows="2" readonly>{{ $response->Survey->description ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="my-1 row">
                            <div class="col-12">
                                <div class="mb-0 form-label-group">
                                    <label for="textarea-counter">Survey Question</label>
                                    <textarea data-length="10" class="form-control char-textarea" id="textarea-counter" rows="2" readonly>{{ $response->Question->question ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="my-1 row">
                            <div class="col-12">
                                <div class="mb-0 form-label-group">
                                    <label for="textarea-counter">Survey Answers</label>
                                    <textarea data-length="10" class="form-control char-textarea" id="textarea-counter" rows="2" readonly>{{ $response->Answer ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="my-1 row">
                            <div class="col-12">
                                <div class="mb-0 form-label-group">
                                    <label for="textarea-counter">Reasons</label>
                                    <textarea data-length="10" class="form-control char-textarea" id="textarea-counter" rows="2" readonly>{{ $response->reason ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
