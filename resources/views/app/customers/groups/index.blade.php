@extends('layouts.app')
{{-- page header --}}
@section('title','Customer Category')
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Customer</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.contact.groups.index') !!}">Category</a></li>
         <li class="breadcrumb-item active">Index</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-sitemap"></i> Customer Category</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="1%">#</th>
                              <th>Name</th>
                              <th width="30%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($groups as $group)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>{!! $group->name !!}</td>
                              <td>
                                 @permission('update-customercategory')
                                    <a href="{!! route('finance.contact.groups.edit',$group->id) !!}" class="btn btn-pink btn-sm"><i class="far fa-edit"></i> Edit</a>
                                 @endpermission
                                 @permission('delete-customercategory')
                                    <a href="{!! route('finance.contact.groups.delete',$group->id) !!}" class="btn btn-danger delete btn-sm"><i class="fas fa-trash"></i> Delete</a>
                                 @endpermission
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Add Category</h4>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     {!! Form::open(array('route' => 'finance.contact.groups.store')) !!}
                        @csrf
                        <div class="form-group form-group-default required">
                           {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                           {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Group Name','required' => '')) !!}
                        </div>
                        <div class="form-group mt-4">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Group</button>
                              <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                           </center>
                        </div>
                     {!! Form::close() !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection