@extends('layouts.app1')


@section('title', 'Warehouse Details')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
<link rel="stylesheet" href="{{asset('css/base/pages/app-invoice.css')}}">
@endsection

@section('content')
<section class="invoice-preview-wrapper">
      @include('partials._messages')
  <div class="row invoice-preview">
    <!-- Invoice -->
    <div class="col-xl-9 col-md-8 col-12">
      <div class="card invoice-preview-card">
        <div class="card-body invoice-padding pb-0">
          <!-- Header starts -->
          <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
            <div>
              <div class="logo-wrapper">

              </div>
              <p class="card-text mb-25"><b> {{ $warehouse->name ?? '' }} </b></p>
              <p class="card-text mb-25">{{ $warehouse->region->name ?? '' }}</p>
              <p class="card-text mb-0"> {{ $warehouse->subregion->name ?? '' }} </p>
            </div>
            <div class="mt-md-0 mt-2">
              <h4 class="invoice-title">
                Wirehouse Code 
                <span class="invoice-number">#{{ $warehouse->warehouse_code ?? '' }}</span>
              </h4>
              <div class="invoice-date-wrapper">
                <p class="invoice-date-title">Date created:</p>
                <p class="invoice-date">{!! $warehouse->created_at !!}</p>
              </div>
           
                <div class="invoice-date-wrapper">
                <p class="invoice-date-title">Status:</p>
               
                <p class="invoice-date">  
                   @if ($warehouse->status === 'Active')
                         <span class="badge badge-pill badge-light-success mr-1">Active</span>
                   @else
                        <span class="badge badge-pill badge-light-warning mr-1">Disabled</span>
                   @endif
               </p>
              </div>
            </div>
          </div>
          <!-- Header ends -->
        </div>

        <hr class="invoice-spacing" />


        <!-- Invoice Description starts -->
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th class="py-1">Name</th>
                <th class="py-1">Role</th>
                <th class="py-1">Assigned On</th>
                <th class="py-1">Assigned By</th>
              </tr>
            </thead>
            <tbody>
            @if ($attendees->isEmpty())
                     <tr class="border-bottom">
                        <td class="py-1" colspan="4" style="text-align: center;">
                           <p>No Warehouse Manager assigned at the Moment !!</p>
                           <a href="{!! route('warehousing.assign',['warehouse_code'=> $warehouse->warehouse_code]) !!}" style="text-align: center;" type="button" class="dropdown-item btn btn-sm" style="color: #a6f6a6; font-weight: bold; width: 200px">Assign a Manager</a>
                        </td>
                     </tr>
            @else
            @foreach ($attendees as $attendee)
            <tr class="border-bottom">
                <td class="py-1">
                  <p class="card-text font-weight-bold mb-25">{{ $attendee->managers->name ?? '' }} </p>
             
                </td>
                <td class="py-1">
                  <span class="font-weight-bold">{{ $attendee->position ?? ''}}</span>
                </td>
                <td class="py-1">
                  <span class="font-weight-bold">{{ $attendee->created_at ?? '' }}</span>
                </td>
                <td class="py-1">
                  <span class="font-weight-bold"> {{ $attendee->user->name ?? '' }} </span>
                </td>
              </tr>
              @endforeach
              @endif

     
            </tbody>
          </table>
        </div>

      
        <!-- Invoice Description ends -->

        <hr class="invoice-spacing" />

        <!-- Invoice Note starts -->
        <!-- <div class="card-body invoice-padding pt-0">
          <div class="row">
            <div class="col-12">
              <span class="font-weight-bold">Note:</span>
              <span> Extra note such as company or payment information...</span
              >
            </div>
          </div>
        </div> -->
        <!-- Invoice Note ends -->
      </div>
    </div>
    <!-- /Invoice -->

    <!-- Invoice Actions -->
    <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
      <div class="card">
        <div class="card-body">
        @if ($attendees->isEmpty())
          <a   href="{!! route('warehousing.assign',['warehouse_code'=> $warehouse->warehouse_code]) !!}" class="btn btn-primary btn-block mb-75" >
          Assign Manager
          </a>
        @endif
        <button class="btn btn-outline-secondary btn-block btn-download-invoice mb-75 d-none">Download</button>
<a class="btn btn-outline-secondary btn-block mb-75" href="{{ url()->previous() }}" >
  Back
</a>

   
        </div>
      </div>
    </div>
    <!-- /Invoice Actions -->
  </div>
</section>

@endsection

@section('vendor-script')
<script src="{{asset('vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
@endsection