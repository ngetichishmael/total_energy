@extends('layouts.app')
{{-- page header --}}
@section('title','Supplier Category')
{{-- page styles --}}

{{-- content section --}}
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Supplier Categories</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Suppliers</a></li>
                     <li class="breadcrumb-item"><a href="#">Category</a></li>
                     <li class="breadcrumb-item active">Edit</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
      @include('partials._messages')
      <!-- begin card -->
      <div class="row">
         <div class="col-md-6">
            <div class="card card-inverse">
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>Name</th>
                           <th width="27%">Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($categories as $group)
                        <tr>
                           <td>{!! $count++ !!}</td>
                           <td>{!! $group->name !!}</td>
                           <td>
                              <a href="{!! route('supplier.category.edit',$group->id) !!}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                              <a href="{!! route('supplier.category.delete',$group->id) !!}" class="btn btn-danger delete btn-sm"><i class="fas fa-trash"></i></a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card">
               <div class="card-body">
                  <div class="card-body">
                     <h4 class="card-title">Update Category</h4>
                     {!! Form::model($edit, ['route' => ['supplier.category.update',$edit->id], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
                        @csrf
                        <div class="form-group form-group-default required">
                           {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                           {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Group Name','required' => '')) !!}
                        </div>
                        <div class="form-group mt-4">
                           <center>
                              <button type="submit" class="btn btn-primary submit"><i class="fas fa-save"></i> Update Category</button>
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
