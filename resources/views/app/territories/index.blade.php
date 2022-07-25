@extends('layouts.app')
{{-- page header --}}
@section('title','Territories')
{{-- page styles --}}

@section('stylesheets')
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/css/extensions/jstree.min.css') !!}">
@endsection

{{-- content section --}}
@section('content')
   @include('partials._messages')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Territory</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item active"><a href="#">Territory</a></li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- begin card -->
   @livewire('territory.index')
@endsection
{{-- page scripts --}}
@section('scripts')
   <script src="{!! asset('app-assets/vendors/js/extensions/jstree.min.js') !!}"></script>
   <!-- BEGIN: Page JS-->
   <script src="{!! asset('app-assets/js/scripts/extensions/ext-component-tree.min.js') !!}"></script>
   <!-- END: Page JS-->
@endsection
