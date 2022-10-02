@extends('layouts.app')
@section('title','Survey Details')
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0"> Survey - {!! $survey->title !!} </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="/">Home</a></li>
                     <li class="breadcrumb-item"><a href="{!! route('survey.index') !!}">Survey</a></li>
                     <li class="breadcrumb-item">{!! $survey->title !!}</li>
                     <li class="breadcrumb-item">Details</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   @include('partials._messages')
   <div class="row">
      <div class="col-md-6">
         @include('app.survey._menu')
      </div>
      <div class="col-md-12">
         <div class="col-md-8">
            <div class="card">
               <div class="card-body">
                  <div class="row">
         <div class="col-sm-6">
            <div>
                  <span class="text-sm text-grey-m2 align-middle">Title:</span>
                  <i><span class="text-600 text-110 text-blue align-middle"> {!! $survey->title !!}</span></i>
            </div>
         </div>
         <!-- /.col -->
         <div class="text-grey-m2">
            <strong><div class="mt-1">Details </div></strong>

            <div class="my-2"><li data-jstree='{"icon" : "fa fa-dot-circle"}'><span class="text-600 text-90">ID:</span> #{!! $survey->id !!}</li>

            <div class="my-2"><li data-jstree='{"icon" : "fa fa-dot-circle"}'><span class="text-600 text-90">Type:</span> {!! $survey->type !!}</li>
            
            <div class="my-2"><li data-jstree='{"icon" : "fa fa-dot-circle"}'><span class="text-600 text-90">Visibility:</span> {!! $survey->visibility !!}</li>

            <div class="my-2"><li data-jstree='{"icon" : "fa fa-dot-circle"}'><span class="text-600 text-90">Status:</span> {!! $survey->status !!}</li>
            </div>
         </div>
      </div>
               </div>
            </div>
         </div>
      </div>
   </div>

@endsection
