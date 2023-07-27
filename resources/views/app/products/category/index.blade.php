@extends('layouts.app1')
{{-- page header --}}
@section('title','Item Category')
{{-- page styles --}}

{{-- content section --}}
@section('content')
@if(Auth::check() && Auth::user()->account_type == 'Admin')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Categories</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Products</a></li>
                     <li class="breadcrumb-item active"><a href="#">Category</a></li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>

   @include('partials._messages')
   <!-- begin card -->
   <div class="card">
    <h5 class="card-header"></h5>
    <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
        <div class="col-md-4 user_role">
            <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i data-feather="search"></i></span>
                </div>
                <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
            </div>
        </div>
        <div class="col-md-2 user_role">
            <div class="form-group">
                <label for="selectSmall">Per Page</label>
                <select wire:model="perPage" class="form-control form-control-sm" id="selectSmall">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <div class="col-md-2 d-flex justify-content-end">
   

            <div class="demo-inline-spacing">
           
            <button type="button" class="btn btn-icon btn-outline-success" wire:click="export"
                wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top" title="Export Excel">
                <img src="{{ asset('assets/img/excel.png') }}"alt="Export Excel" width="25" height="15"
                    data-toggle="tooltip" data-placement="top" title="Export Excel">Export
            </button>
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
                        <th width="20%">Name</th>
                        <th class="text-center" width="15.5%">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($category as $all)
                        <tr>
                           <td>{!! $count++ !!}</td>
                           <td>{!! $all->name !!}</td>

                           {{-- <td>{!! Finance::products_by_category_count($all->id) !!}</td> --}}
                           <td>
                              <div class="d-flex" style="gap:20px">
                                 <a href="{{ route('product.category.edit', $all->id) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>
                                 <a href="{!! route('product.category.destroy', $all->id) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Delete</a>
                              </div>
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
               <!-- <h4 class="card-title">Add Category</h4> -->
               {!! Form::open(array('route' => 'product.category.store')) !!}
                  @csrf
                  <div class="form-group form-group-default required">
                     {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                     {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Category Name','required' => '')) !!}
                  </div>

                  <div class="form-group mt-4">
                     <center>
                        <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Add Category</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
                     </center>
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
   
   @else
   <div class="misc-inner p-2 p-sm-3">
            <div class="w-100 text-center">
                <h2 class="mb-1">You are not authorized! 🔐</h2>
                <p class="mb-2">Sorry, but you do not have the necessary permissions to access this page.</p>
                <img class="img-fluid" src="{{asset('images/pages/not-authorized.svg')}}" alt="Not authorized page" />
            </div>
        </div>
   @endif
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
