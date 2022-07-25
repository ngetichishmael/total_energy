@extends('layouts.app')
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
   </div>
   @include('partials._messages')
   @livewire('warehousing.index')
@endsection
{{-- page scripts --}}
@section('script')

@endsection
