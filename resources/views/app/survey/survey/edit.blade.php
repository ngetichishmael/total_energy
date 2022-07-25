@extends('layouts.app')
@section('title','Edit survey')
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Survey </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Survey</a></li>
                     <li class="breadcrumb-item active">Edit</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   @include('partials._messages')
   <div class="card">
      <div class="card-body">
         {!! Form::model($edit, ['route' => ['survey.update',$edit->code], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group mb-1">
                     {!! Form::label('title', 'Title', array('class'=>'control-label')) !!}
                     {!! Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Title')) !!}
                  </div>
                  {{-- <div class="form-group mb-1">
                     {!! Form::label('title','Category', array('class'=>'control-label')) !!}
                     {{ Form::select('category',$category, null, ['class' => 'form-control', 'required' => '']) }}
                  </div> --}}
                  <div class="form-group mb-1">
                     {!! Form::label('type','Type', array('class'=>'control-label')) !!}
                     {{ Form::select('type',['online'=>'Online'], null, ['class' => 'form-control']) }}
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group mb-1">
                     {!! Form::label('type','Visibility', array('class'=>'control-label')) !!}
                     {{ Form::select('visibility',['Public'=>'Public','Private'=>'Private'], null, ['class' => 'form-control']) }}
                  </div>
                  <div class="form-group mb-1">
                     {!! Form::label('title','Category Status', array('class'=>'control-label')) !!}
                     {{ Form::select('status',[15=>'Active',22=>'Closed'], null, ['class' => 'form-control', 'required' => '']) }}
                  </div>
                  {{-- <div class="form-group mb-1">
                     <label>Image</label>
                     {!! Form::file('image',array('class' => 'form-control', 'id' => 'thumbnail', 'files'=> true)) !!}
                  </div> --}}
               </div>
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Start Date</label>
                           {!! Form::date('start_date',null,['class'=>'form-control']) !!}
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">End Date</label>
                           {!! Form::date('end_date',null,['class'=>'form-control']) !!}
                        </div>
                     </div>

                  </div>
               </div>
               <div class="col-md-12 mb-1 mt-1">
                  <div class="panel-body">
                     <div class="form-group">
                        <label for="">Link to sales person</label>
                        {!! Form::select('description',[],null,['class'=>'form-control my-editor']) !!}
                     </div>
                  </div>
               </div>
               <div class="col-md-12 mt-1 mb-2">
                  <div class="panel-body">
                     <div class="form-group">
                        <label for="">Description</label>
                        {!! Form::textarea('description',null,['class'=>'form-control', 'size' => '6x6', 'placeholder'=>'caption']) !!}
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <center>
                        {!! Form::submit('Update survey',array('class' =>'btn btn-success btn-sm submit')) !!}
                        <img src="{!! asset('assets/images/loader.gif') !!}" alt="" class="submit-load" style="width: 10%">
                     </center>
                  </div>
               </div>
            </div>
         {!! Form::close() !!}
      </div>
   </div>
@endsection
