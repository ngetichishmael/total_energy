@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Warehouse')

{{-- content section --}}
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Edit Warehouse </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Warehouse</a></li>
                     <li class="breadcrumb-item active">Edit</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   @include('partials._messages')
   <div class="row">
      <div class="col-md-6">
         <div class="card">
            <div class="card-body">
               {!! Form::model($edit, ['route' => ['warehousing.update',$edit->warehouse_code], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
                  @csrf
                  <div class="form-group mb-1">
                     <label for="">Name</label>
                     {!! Form::text('name',null,['class'=>'form-control','required'=>'']) !!}
                  </div>
                  <div class="form-group mb-1">
                     <label for="">Email</label>
                     {!! Form::email('email',null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1">
                     <label for="">Phone number</label>
                     {!! Form::text('phone_number',null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1">
                     <label for="">Country</label>
                     {!! Form::select('country',$country,null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1">
                     <label for="">City</label>
                     {!! Form::text('city',null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1">
                     <label for="">Location</label>
                     {!! Form::text('location',null,['class'=>'form-control']) !!}
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group mb-1">
                           <label for="">Longitude</label>
                           {!! Form::text('longitude',null,['class'=>'form-control']) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group mb-1">
                           <label for="">Latitude</label>
                           {!! Form::text('latitude',null,['class'=>'form-control']) !!}
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-check form-switch">
                           <label class="form-check-label" for="customSwitch1">Is main warehouse</label>
                           <input type="checkbox" class="form-check-input" name="is_main" id="customSwitch1" value="Yes" @if($edit->is_main == 'Yes') checked @endif />
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-check form-switch">
                           <label class="form-check-label mb-50" for="customSwitch4">Is Active</label>
                           <input type="checkbox" class="form-check-input" name="status" id="customSwitch4" value="Active"  @if($edit->status == 'Active') checked @endif />
                        </div>
                     </div>
                  </div>
                  <center><button class="btn btn-success mt-2" type="submit"><i data-feather='save'></i> Save Information</button></center>
               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
