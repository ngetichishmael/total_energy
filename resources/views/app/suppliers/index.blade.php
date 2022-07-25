@extends('layouts.app')
{{-- page header --}}
@section('title','Supplier List')

{{-- content section --}}
@section('content')
   <div class="row mb-2">
      <div class="col-md-8">
         <h2 class="page-header"> Supplier</h2>
      </div>
      <div class="col-md-4">
         <center>
            <a href="{!! route('supplier.create') !!}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Add Supplier</a>
            {{-- <a href="{!! route('products.import') !!}" class="btn btn-warning btn-sm"><i class="fas fa-file-upload"></i> Import Products</a> --}}
            {{-- <a href="{!! route('products.export','csv') !!}" class="btn btn-warning btn-sm"><i class="fas fa-file-download"></i> Export Products</a> --}}
         </center>
      </div>
   </div>
   @include('partials._messages')
   <div class="card card-default">
      <div class="card-body">
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone number</th>
                  <th>Date addded</th>
                  <th width="18%">Action</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($suppliers as $supplier)
                  <tr {{-- class="success" --}}>
                     <td>{!! $count++ !!}</td>
                     <td>{!! $supplier->supplier_name !!}</td>
                     <td>{!! $supplier->supplier_email !!}</td>
                     <td>{!! $supplier->phone_number !!}</td>
                     <td>{!! date('d F, Y', strtotime($supplier->created_at)) !!}</td>
                     <td>
                        <a href="{{ route('supplier.edit', $supplier->supplierID) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                        <a href="{!! route('supplier.delete', $supplier->supplierID) !!}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash-alt"></i> Delete</a>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
