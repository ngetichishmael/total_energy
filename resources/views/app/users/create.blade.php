@extends('layouts.app')
{{-- page header --}}
@section('title','Create User')
{{-- page styles --}}
@section('stylesheets')

@endsection


{{-- content section --}}
@section('content')
   <!-- begin breadcrumb -->

   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Users </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Users</a></li>
                     <li class="breadcrumb-item active">Create</li>
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
               <form class="row" method="POST" action="{!! route('user.store') !!}">
                  @csrf
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Name <span class="text-danger">*</span></label>
                     {!! Form::text('name',null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Email <span class="text-danger">*</span></label>
                     {!! Form::email('email',null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Phone Number <span class="text-danger">*</span></label>
                     {!! Form::number('phone_number',null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">User Type <span class="text-danger">*</span></label>
                     {!! Form::select('account_type',[''=>'Choose','Sales' => 'Sales', 'Admin'=> 'Admin'],null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1 col-md-12">
                     <center><button class="btn btn-success" type="submit">Save information</button></center>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
