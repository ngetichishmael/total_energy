@extends('layouts.app')
{{-- page header --}}
@section('title','All Notifications')

{{-- content section --}}
@section('content')
   <div class="content-header row">
      <div class="mb-2 content-header-left col-md-12 col-12">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="mb-0 content-header-title float-start">All Notification</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">All</a></li>
                     <li class="breadcrumb-item"><a href="#">Available</a></li>
                     <li class="breadcrumb-item active">Notifications</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end breadcrumb -->
   @livewire('notification.all.index')
@endsection
{{-- page scripts --}}
@section('script')

@endsection
