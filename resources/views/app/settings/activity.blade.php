@extends('layouts.app')
@section('title','Activity Logs')
@section('stylesheets')
@endsection
@section('content')
   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Account Details</h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Account</a></li>
                     <li class="breadcrumb-item active">Account Details</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      @include('app.settings._menu')

      <div class="col-md-8">
         <div class="card">
            <div class="card-body">
               @foreach ($activities as $activity)
                  <p>{!! $activity->activity !!}</p>
               @endforeach
            </div>
         </div>


         <!-- Activity Timeline -->
         {{-- <div class="card">
            <h4 class="card-header">User Activity Timeline</h4>
            <div class="card-body pt-1">
               <ul class="timeline ms-50">
                  <li class="timeline-item">
                  <span class="timeline-point timeline-point-indicator"></span>
                  <div class="timeline-event">
                     <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                        <h6>User login</h6>
                        <span class="timeline-event-time me-1">12 min ago</span>
                     </div>
                     <p>User login at 2:12pm</p>
                  </div>
                  </li>
                  <li class="timeline-item">
                  <span class="timeline-point timeline-point-warning timeline-point-indicator"></span>
                  <div class="timeline-event">
                     <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                        <h6>Meeting with john</h6>
                        <span class="timeline-event-time me-1">45 min ago</span>
                     </div>
                     <p>React Project meeting with john @10:15am</p>
                     <div class="d-flex flex-row align-items-center mb-50">
                        <div class="avatar me-50">
                        <img
                           src="../../../app-assets/images/portrait/small/avatar-s-7.jpg"
                           alt="Avatar"
                           width="38"
                           height="38"
                        />
                        </div>
                        <div class="user-info">
                        <h6 class="mb-0">Leona Watkins (Client)</h6>
                        <p class="mb-0">CEO of pixinvent</p>
                        </div>
                     </div>
                  </div>
                  </li>
                  <li class="timeline-item">
                  <span class="timeline-point timeline-point-info timeline-point-indicator"></span>
                  <div class="timeline-event">
                     <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                        <h6>Create a new react project for client</h6>
                        <span class="timeline-event-time me-1">2 day ago</span>
                     </div>
                     <p>Add files to new design folder</p>
                  </div>
                  </li>
                  <li class="timeline-item">
                  <span class="timeline-point timeline-point-danger timeline-point-indicator"></span>
                  <div class="timeline-event">
                     <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                        <h6>Create Invoices for client</h6>
                        <span class="timeline-event-time me-1">12 min ago</span>
                     </div>
                     <p class="mb-0">Create new Invoices and send to Leona Watkins</p>
                     <div class="d-flex flex-row align-items-center mt-50">
                        <img class="me-1" src="../../../app-assets/images/icons/pdf.png" alt="data.json" height="25" />
                        <h6 class="mb-0">Invoices.pdf</h6>
                     </div>
                  </div>
                  </li>
               </ul>
            </div>
         </div> --}}
         <!-- /Activity Timeline -->
      </div>
   </div>
@endsection
@section('scripts')
@endsection
