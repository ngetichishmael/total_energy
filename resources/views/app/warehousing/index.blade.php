@extends('layouts.app1')
{{-- page header --}}
@section('title','Warehousing List')

{{-- content section --}}
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Warehousing </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Warehousing</a></li>
                     <li class="breadcrumb-item active">List</li>
                  </ol>
               </div>
            </div>
         </div>
   </div>
      <!-- <div class="mb-2 row col-12 pe-1 mr-1 pr-0">
         <center>
            <a href="{!! route('warehousing.create') !!}" class="btn btn-md" style="background-color: #24B263;color:white">Add Warehouse</a>
            <a href="{!! route('warehousing.import') !!}" class="btn btn-md" style="background-color: #24B263;color:white">Import Warehouses</a>
         </center>
      </div> -->
   </div>

   @include('partials._messages')
   @livewire('warehousing.index')
@endsection
{{-- page scripts --}}
@section('script')

@endsection
