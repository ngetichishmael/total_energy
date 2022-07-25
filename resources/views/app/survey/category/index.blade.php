@extends('layouts.app')
@section('title','All Category | Wingu CMS')
@section('breadcrumb')
   <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1 breadcrumb-new">
         <h3 class="content-header-title mb-0 d-inline-block"><i class="fal fa-folder-tree"></i> Category</h3>
         <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{!! url('/') !!}">Home</a></li>
                  <li class="breadcrumb-item"><a href="{!! url('/') !!}">Trivia</a></li>
                  <li class="breadcrumb-item"><a href="{!! route('trivia.category.index') !!}">Category</a></li>
                  <li class="breadcrumb-item active">All</li>
               </ol>
            </div>
         </div>
      </div>
      <div class="content-header-right col-md-6 col-12"><a href="{!! route('trivia.category.create') !!}" class="btn btn-sm btn-warning float-right"><i class="fal fa-plus-circle"></i> Add Category</a></div>
   </div>
@endsection
@section('content')
   @include('partials._messages')
   <div class="card">
      <div class="card-body">
         <table class="table table-striped table-bordered zero-configuration">
            <thead>
               <tr>
                  <th width="1%">#</th> 
                  <th width="6%"></th>
                  <th>Title</th>
                  <th>Status</th>
                  <th width="10%">Date Create</th>
                  <th width="8%">Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($categories as $slider)
                  <tr class="odd gradeX">
                     <td width="1%" class="f-s-600 text-inverse">{!! $count++ !!}</td>
                     <td ><img src="{!! asset('trivia/category/'.$slider->image)!!}" class="img-responsive"/></td>
                     <td>{!! $slider->title !!}</td>
                     <td>
                        @if($slider->status == 'In-Active')
                           <span class="label label-default">In-Active</span>
                        @else($slider->status == 1)
                           <span class="label label-success">Active</span>
                        @endif
                     </td>
                     <td>{{ date('j M Y',strtotime($slider->updated_at)) }}</td>
                     <td>
                        <a href="{!! route('trivia.category.edit',$slider->id) !!}" class="btn btn-sm btn-info"><i class="far fa-edit" aria-hidden="true"></i></a>
                        <a href="{!! route('trivia.category.delete',$slider->id) !!}" class="btn btn-sm btn-danger delete"><i class="far fa-trash-alt" aria-hidden="true"></i></a>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
@endsection
