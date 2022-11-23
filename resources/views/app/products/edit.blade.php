@extends('layouts.app')
{{-- page header --}}
@section('title', 'Edit Product')
@section('stylesheet')
    <style>
        ul.product li {
            width: 100%;
        }
    </style>
@endsection

{{-- content section --}}
@section('content')
    <!-- begin page-header -->
    <h3 class="page-header"> Edit Products</h3>
    <!-- end page-header -->
    <div class="row">
        @include('app.products._product_menu')
        <!-- Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row g-1">
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Multiple Column</h4>
                        </div>
                        <div class="card-body">
                            <form class="form">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">First Name</label>
                                            <input type="text" id="first-name-column" class="form-control"
                                                placeholder="First Name" name="fname-column" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Last Name</label>
                                            <input type="text" id="last-name-column" class="form-control"
                                                placeholder="Last Name" name="lname-column" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="city-column">City</label>
                                            <input type="text" id="city-column" class="form-control" placeholder="City"
                                                name="city-column" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="country-floating">Country</label>
                                            <input type="text" id="country-floating" class="form-control"
                                                name="country-floating" placeholder="Country" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="company-column">Company</label>
                                            <input type="text" id="company-column" class="form-control"
                                                name="company-column" placeholder="Company" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Email</label>
                                            <input type="email" id="email-id-column" class="form-control"
                                                name="email-id-column" placeholder="Email" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="reset" class="btn btn-primary mr-1">Submit</button>
                                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Basic Floating Label Form section end -->
    <div class="col-md-9">
        {!! Form::model($product, [
            'route' => ['products.update', $product->productID],
            'method' => 'post',
            'data-parsley-validate' => '',
            'enctype' => 'multipart/form-data',
        ]) !!}
        {!! csrf_field() !!}
        <div class="card card-default">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group mb-1 form-group-default required">
                            {!! Form::label('title', 'Name', ['class' => 'control-label text-danger']) !!}
                            {!! Form::text('product_name', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Enter Product Name',
                                'required' => '',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-1 form-group-default required ">
                            {!! Form::label('title', 'Status', ['class' => 'control-label text-danger']) !!}
                            {{ Form::select('status', ['Active' => 'Active'], null, ['class' => 'form-control multiselect', 'required' => '']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-1 form-group-default required">
                            {!! Form::label('title', 'SKU code', ['class' => 'control-label']) !!}
                            {!! Form::text('sku_code', null, ['class' => 'form-control', 'placeholder' => 'SKU code', 'required' => '']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-1 form-group-default">
                            {!! Form::label('title', 'Brand', ['class' => 'control-label']) !!}
                            <select name="brandID" id="brandID" class="form-control">
                                @foreach ($brands as $brand)
                                    <option value='{{ $brand }}'
                                        {{ $brand == $product->productName ? 'selected' : '' }}> {{ $brand }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-1 form-group-default">
                            {!! Form::label('title', 'Supplier', ['class' => 'control-label']) !!}
                            {!! Form::select('supplierID', $suppliers, null, ['class' => 'form-control multiselect']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-1 required form-group-default">
                            {!! Form::label('title', 'Product category', ['class' => 'control-label']) !!}
                            {{ Form::select('category', $category, null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb-1 mt-3">
                            <center>
                                <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update
                                    Item</button>
                                <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt=""
                                    width="25%">
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
</div>
@endsection
{{-- page scripts --}}
@section('scripts')
@endsection
