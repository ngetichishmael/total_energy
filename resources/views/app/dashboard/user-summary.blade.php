@extends('layouts.app')
@section('title','User Summary')
@section('stylesheets')
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/plugins/charts/chart-apex.min.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/pages/dashboard-ecommerce.min.css') !!}">
   <style>
      .font-weight-lighter {
         font-weight: 300;
      }
   </style>
@endsection
@section('content')
   <div class="row">
      <div class="col-md-12">
         <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Sales summary</button>
            </li>
            <li class="nav-item" role="presentation">
               <a class="nav-link active" href="{!! route('app.dashboard.user.summary') !!}">Employees summary</a>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Customers summary</button>
            </li>
          </ul>
      </div>
      <div class="col-md-12">
         <h2>Users Summary</h2>
         <hr>
      </div>
      <div class="row">
         <div class="col-md-4">
            <h2 class="font-weight-lighter">Within the hour | 1</h2>
            <h2 class="font-weight-lighter">Active Users | 6</h2>
            <h2 class="font-weight-lighter">Inactive Users | 4</h2>
            <h2 class="font-weight-lighter">Dormant Users | 6</h2>
         </div>
         <div class="col-md-8">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8171118.3723060675!2d33.409983678067704!3d0.1540843327377215!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182780d08350900f%3A0x403b0eb0a1976dd9!2sKenya!5e0!3m2!1sen!2ske!4v1638290237323!5m2!1sen!2ske" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/js/charts/apexcharts.min.js') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/js/scripts/pages/dashboard-ecommerce.min.js') !!}">
@endsection
