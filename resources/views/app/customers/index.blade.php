@extends('layouts.app')
{{-- page header --}}
@section('title','Customer')
{{-- page styles --}}
@section('stylesheets')

@endsection


{{-- content section --}}
@section('content')
   <!-- begin breadcrumb -->
   <div class="row mb-2">
      <div class="col-md-8">
         <h2 class="page-header">Customers List</h2>
      </div>
      <div class="col-md-4">
         <center>
            <a href="{!! route('customer.create') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Add a Customer</a>
            <a href="{!! route('customer.import') !!}" class="btn btn-info btn-sm"><i class="fa fa-file-upload"></i> Import Customer</a>
            {{-- <a href="{!! route('customer.export','csv') !!}" class="btn btn-warning btn-sm"><i class="fal fa-file-download"></i> Export Customer</a> --}}
         </center>
      </div>
   </div>
   <!-- end breadcrumb -->
   <div class="row mb-1">
      <div class="col-md-10">
         <label for="">Search</label>
         <input type="text" wire:model="search" class="form-control" placeholder="Enter customer name, email address or phonenumber">
      </div>
      <div class="col-md-2">
         <label for="">Items Per</label>
         <select wire:model="perPage" class="form-control">`
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
         </select>
      </div>
   </div>
   <div class="card card-default">
      <div class="card-body">
         <table class="table table-striped table-bordered">
            <thead>
               <th width="1%">#</th>
               <th>Name</th>
               <th>Email</th>
               <th>Phonenumber</th>
               <th>Address</th>
               <th width="15%">Action</th>
            </thead>
            <tbody>
               @foreach ($contacts as $count=>$contact)
                  @if($contact->businessID == Auth::user()->businessID)
                     <tr {{-- class="success" --}}>
                        <td>{!! $count+1 !!}</td>
                        <td>
                           {!! $contact->customer_name !!}
                        </td>
                        <td>{!! $contact->customer_email !!}</td>
                        <td>{!! $contact->phone_number !!}</td>
                        <td>
                           {!! $contact->address !!}
                        </td>
                        <td>
                           {{-- <a href="#" class="btn btn-sm btn-warning">View</a> --}}
                           <a href="{{ route('customer.edit', $contact->customerID) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                     </tr>

                  @endif
               @endforeach
            </tbody>
         </table>
         <br>
         <br>
         {!! $contacts->links() !!}
         <br>
         <br>
      </div>
   </div>
   {{-- @livewire('customers.index') --}}
@endsection
{{-- page scripts --}}
@section('script')

@endsection
