@extends('layouts.app')
{{-- page header --}}
@section('title','Update Brand ')

{{-- content section --}}
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Brands</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Products</a></li>
                     <li class="breadcrumb-item"><a href="#">Brands</a></li>
                     <li class="breadcrumb-item active"><a href="#">Edit</a></li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="card card-inverse">
            <div class="card-body">
               <table id="data-table-default" class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th>Name</th>
                        {{-- <th>Products</th> --}}
                        <th width="20%">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($brands as $br)
                        <tr>
                           <td>{!! $count++ !!}</td>
                           <td>{!! $br->name !!}</td>
                           {{-- <td>{!! Finance::products_by_brand_count($br->id) !!}</td> --}}
                           <td>
                              <a href="{{ route('product.brand.edit', $br->id) }}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                              <a href="{!! route('product.brand.destroy', $br->id) !!}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="card card-default">
            <div class="card-body">
               <h4 class="card-title">Update Brand</h4>
               {!! Form::model($brand, ['route' => ['product.brand.update',$brand->id], 'method'=>'post','enctype'=>'multipart/form-data','data-parsley-validate' => '']) !!}
                  @csrf
                  <div class="form-group form-group-default required">
                     {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                     {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Brand Name','required' => '')) !!}
                  </div>
                  <div class="form-group mt-4">
                     <center>
                        <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update brand</button>
                     </center>
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
