@extends('layouts.app1')

@section('title', 'Inventory')

@section('content')
    <!-- begin breadcrumb -->
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Inventory for Warehouse : <b> {!! $warehouse->name !!}
                    </h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('warehousing.index') }}">Warehousing</a></li>
                            <li class="breadcrumb-item active">Product List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @include('partials._messages')
        <div>

            <div class="card">
                <h5 class="card-header"></h5>
                <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                    <div class="col-md-4 user_role">
                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i data-feather="search"></i></span>
                            </div>
                            <input wire:model.debounce.300ms="search" type="text" id="fname-icon" class="form-control"
                                name="fname-icon" placeholder="Search" />
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

                    <div class="col-md-4 d-flex justify-content-end">
                        <div class="demo-inline-spacing">
                            <a href="{!! route('products.create') !!}" class="btn btn-outline-secondary">Add Product</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-default">
            <div class="card-body">
                <table class="table table-striped table-bordered" style="font-size: small">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Name</th>
                            <th>Wholesale Price</th>
                            <th>Retail Price</th>
                            <th>SKU Volume</th>
                            <th>Current Stock</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $key => $product)
                            <tr>
                                <td>{!! $key + 1 !!}</td>
                                <td>{!! $product->product_name !!}</td>

                                @if ($product->ProductPrice->buying_price == 0)
                                    <td>{{ 'Price Not set' }}</td>
                                @else
                                    <td>{{ number_format((float) $product->ProductPrice->buying_price) }}</td>
                                @endif
                                <td>
                                    {{ number_format((float) $product->ProductPrice()->pluck('selling_price')->implode('')) }}
                                </td>
                                <td>{{ $product->sku_code }}</td>
                                <td>
                                    @php
                                        $current_stock = $product
                                            ->Inventory()
                                            ->pluck('current_stock')
                                            ->implode('');
                                        $current_stock = $current_stock > 0 ? $current_stock : 0;
                                    @endphp
                                    {{ $current_stock }}

                                </td>
                                <td>{{ $product->updated_at->format('d/m/Y h:i A') }}</td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle show-arrow"
                                            data-toggle="dropdown" style="background-color: #089000; color:white">
                                            <i data-feather="settings"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('products.restock', $product->id) }}">
                                                <i data-feather="plus-circle" class="mr-50"></i>
                                                <span>Re Stock</span>
                                            </a>
                                            <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">
                                                <i data-feather="edit" class="mr-50"></i>
                                                <span>Edit</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No product(s) found</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>

            </div>
        </div>

    @endsection

    @section('script')

    @endsection
