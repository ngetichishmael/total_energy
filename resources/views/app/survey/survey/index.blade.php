@extends('layouts.app')
@section('title','Survey')

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
                     <li class="breadcrumb-item active">List</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   @include('partials._messages')
   <div class="row">
      <div class="col-md-12">
         <a href="{!! route('survey.create') !!}" class="btn btn-primary btn-sm mb-2">Add Survey</a>
         <div class="card">
            <div class="card-body">
               <table class="table table-striped table-bordered zero-configuration">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        {{-- <th width="6%"></th> --}}
                        <th>Title</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date Create</th>
                        <th width="16%">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($surveries as $count=>$survery)
                        <tr class="odd gradeX">
                           <td width="1%" class="f-s-600 text-inverse">{!! $count+1 !!}</td>
                           {{-- <td ><img src="{!! asset('survey/trivia/'.$survery->image)!!}" class="img-responsive"/></td> --}}
                           <td>{!! $survery->title !!}</td>
                           <td>
                              {{ date('j M Y',strtotime($survery->start_date)) }}
                           </td>
                           <td>{{ date('j M Y',strtotime($survery->end_date)) }}</td>
                           <td>{!! $survery->type !!}</td>
                           <td><span class="badge {!! $survery->name !!}">{!! $survery->name !!}</span></td>
                           <td>{{ date('j M Y',strtotime($survery->updated_at)) }}</td>
                           <td>
                              <a href="{!! route('survey.show',$survery->code) !!}" class="btn btn-sm btn-warning"><i class="fas fa-eye" aria-hidden="true"></i></a>
                              <a href="{!! route('survey.edit',$survery->code) !!}" class="btn btn-sm btn-info"><i class="far fa-edit" aria-hidden="true"></i></a>
                              <a href="{!! route('survey.delete',$survery->code) !!}" class="btn btn-sm btn-danger delete"><i class="far fa-trash-alt" aria-hidden="true"></i></a>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
@endsection
