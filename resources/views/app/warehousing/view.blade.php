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

   @include('partials._messages')
   <div>
      <div class="d-flex justify-content-end">
         <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">
            @if ($attendees->isEmpty())
               <a href="{!! route('warehousing.assign',['warehouse_code'=> $warehouse->warehouse_code]) !!}" class="btn btn-primary btn-block mb-75">
                  Assign Manager
               </a>
            @endif
            <button class="btn btn-outline-secondary btn-block btn-download-invoice btn-md d-none">Download</button>
            <a class="btn btn-outline-danger btn-md" href="{{ url()->previous() }}">
               Back
            </a>
         </div>
      </div>

   <div class="row mt-4">
      <!-- User Sidebar -->
      <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
         <!-- User Card -->
         <div class="card mb-4">
            <div class="card-body">
               <div class="user-avatar-section">
                  <div class=" d-flex align-items-center flex-column">
                     <h4 class="mb-2">{{ Str::upper($warehouse->name ?? '') }}</h4>
                  </div>
               </div>
               <p class="mt-4 small text-uppercase text-muted">Details</p>
               <div class="info-container">
                  <ul class="list-unstyled">
                     <li class="mb-2">
                        <span class="fw-semibold me-1">Name:</span>
                        <span>{{ Str::upper($warehouse->name) }}</span>
                     </li>
                     <li class="mb-2">
                        <span class="fw-semibold me-1">Warehouse:</span>
                        <span>{{ Str::upper($warehouse->warehouse_code) }}</span>
                     </li>
                     <li class="mb-2 pt-1">
                        <span class="fw-semibold me-1">Region:</span>
                        <span>{{ $warehouse->region->name }}</span>
                     </li>
                     <li class="mb-2 pt-1">
                        <span class="fw-semibold me-1">Subregion:</span>
                        <span>{{ $warehouse->subregion->name }}</span>
                     </li>
                     <li class="mb-2 pt-1">
                        <span class="fw-semibold me-1">Status:</span>
                        <span style="color: {{ $warehouse->status === 'Active' ? 'green' : 'gray' }}">
                      @if($warehouse->status === 'Active')
                              Active
                           @else
                              {{ $warehouse->status }}
                           @endif
</span>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <!--/ User Sidebar -->


      <!-- User Content -->
      <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
         <!-- User Pills -->
         <ul class="nav nav-pills flex-column flex-md-row mb-4">
            <li class="nav-item">
               <a class="nav-link active" data-bs-toggle="tab" href="#managers-tab">
                  <i class="ti ti-user-check ti-xs me-1"></i>Managers
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-bs-toggle="tab" href="#orders-tab">
                  <i class="ti ti-lock ti-xs me-1"></i>Orders
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-bs-toggle="tab" href="#payments-tab">
                  <i class="ti ti-currency-dollar ti-xs me-1"></i>Payments
               </a>
            </li>
         </ul>

         <div class="tab-content">
            <div class="tab-pane fade show active" id="managers-tab">
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
            </div>
            <div class="tab-pane fade" id="orders-tab">
               <!-- Orders Timeline -->
{{--               @livewire('customer.order', [--}}
{{--               'customer_id' => $warehouse_id,--}}
{{--               ])--}}
               <!-- /Orders Timeline -->
            </div>
            <div class="tab-pane fade" id="payments-tab">
               <!-- Payments Timeline -->
{{--               @livewire('customer.payment', [--}}
{{--               'customer_id' => $warehouse_id,--}}
{{--               ])--}}
               <!-- /Payments Timeline -->
            </div>
         </div>
      </div>

      <!--/ User Content -->

   </div>
   </div>
{{--<section class="invoice-preview-wrapper">--}}

{{--  <div class="row invoice-preview">--}}
{{--    <!-- Invoice -->--}}
{{--    <div class="col-xl-9 col-md-8 col-12">--}}
{{--      <div class="card invoice-preview-card">--}}
{{--        <div class="card-body invoice-padding pb-0">--}}
{{--          <!-- Header starts -->--}}
{{--          <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">--}}
{{--            <div>--}}
{{--              <div class="logo-wrapper">--}}

{{--              </div>--}}
{{--              <p class="card-text mb-25"><b> {{ $warehouse->name ?? '' }} </b></p>--}}
{{--              <p class="card-text mb-25">{{ $warehouse->region->name ?? '' }}</p>--}}
{{--              <p class="card-text mb-0"> {{ $warehouse->subregion->name ?? '' }} </p>--}}
{{--            </div>--}}
{{--            <div class="mt-md-0 mt-2">--}}
{{--              <h4 class="invoice-title">--}}
{{--                Wirehouse Code--}}
{{--                <span class="invoice-number">#{{ $warehouse->warehouse_code ?? '' }}</span>--}}
{{--              </h4>--}}
{{--              <div class="invoice-date-wrapper">--}}
{{--                <p class="invoice-date-title">Date created:</p>--}}
{{--                <p class="invoice-date">{!! $warehouse->created_at !!}</p>--}}
{{--              </div>--}}

{{--                <div class="invoice-date-wrapper">--}}
{{--                <p class="invoice-date-title">Status:</p>--}}

{{--                <p class="invoice-date">--}}
{{--                   @if ($warehouse->status === 'Active')--}}
{{--                         <span class="badge badge-pill badge-light-success mr-1">Active</span>--}}
{{--                   @else--}}
{{--                        <span class="badge badge-pill badge-light-warning mr-1">Disabled</span>--}}
{{--                   @endif--}}
{{--               </p>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <!-- Header ends -->--}}
{{--        </div>--}}

{{--        <hr class="invoice-spacing" />--}}


{{--        <!-- Invoice Description starts -->--}}
{{--        <div class="table-responsive">--}}
{{--          <table class="table">--}}
{{--            <thead>--}}
{{--              <tr>--}}
{{--                <th class="py-1">Name</th>--}}
{{--                <th class="py-1">Role</th>--}}
{{--                <th class="py-1">Assigned On</th>--}}
{{--                <th class="py-1">Assigned By</th>--}}
{{--              </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @if ($attendees->isEmpty())--}}
{{--                     <tr class="border-bottom">--}}
{{--                        <td class="py-1" colspan="4" style="text-align: center;">--}}
{{--                           <p>No Warehouse Manager assigned at the Moment !!</p>--}}
{{--                           <a href="{!! route('warehousing.assign',['warehouse_code'=> $warehouse->warehouse_code]) !!}" style="text-align: center;" type="button" class="dropdown-item btn btn-sm" style="color: #a6f6a6; font-weight: bold; width: 200px">Assign a Manager</a>--}}
{{--                        </td>--}}
{{--                     </tr>--}}
{{--            @else--}}
{{--            @foreach ($attendees as $attendee)--}}
{{--            <tr class="border-bottom">--}}
{{--                <td class="py-1">--}}
{{--                  <p class="card-text font-weight-bold mb-25">{{ $attendee->managers->name ?? '' }} </p>--}}

{{--                </td>--}}
{{--                <td class="py-1">--}}
{{--                  <span class="font-weight-bold">{{ $attendee->position ?? ''}}</span>--}}
{{--                </td>--}}
{{--                <td class="py-1">--}}
{{--                  <span class="font-weight-bold">{{ $attendee->created_at ?? '' }}</span>--}}
{{--                </td>--}}
{{--                <td class="py-1">--}}
{{--                  <span class="font-weight-bold"> {{ $attendee->user->name ?? '' }} </span>--}}
{{--                </td>--}}
{{--              </tr>--}}
{{--              @endforeach--}}
{{--              @endif--}}


{{--            </tbody>--}}
{{--          </table>--}}
{{--        </div>--}}


{{--        <!-- Invoice Description ends -->--}}

{{--        <hr class="invoice-spacing" />--}}

{{--        <!-- Invoice Note starts -->--}}
{{--        <!-- <div class="card-body invoice-padding pt-0">--}}
{{--          <div class="row">--}}
{{--            <div class="col-12">--}}
{{--              <span class="font-weight-bold">Note:</span>--}}
{{--              <span> Extra note such as company or payment information...</span--}}
{{--              >--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div> -->--}}
{{--        <!-- Invoice Note ends -->--}}
{{--      </div>--}}
{{--    </div>--}}
{{--    <!-- /Invoice -->--}}

{{--    <!-- Invoice Actions -->--}}
{{--    <div class="col-xl-3 col-md-4 col-12 invoice-actions mt-md-0 mt-2">--}}
{{--      <div class="card">--}}
{{--        <div class="card-body">--}}
{{--        @if ($attendees->isEmpty())--}}
{{--          <a   href="{!! route('warehousing.assign',['warehouse_code'=> $warehouse->warehouse_code]) !!}" class="btn btn-primary btn-block mb-75" >--}}
{{--          Assign Manager--}}
{{--          </a>--}}
{{--        @endif--}}
{{--        <button class="btn btn-outline-secondary btn-block btn-download-invoice mb-75 d-none">Download</button>--}}
{{--<a class="btn btn-outline-secondary btn-block mb-75" href="{{ url()->previous() }}" >--}}
{{--  Back--}}
{{--</a>--}}


{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--    <!-- /Invoice Actions -->--}}
{{--  </div>--}}
{{--</section>--}}

@endsection

@section('vendor-script')
<script src="{{asset('vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/app-invoice.js')}}"></script>
@endsection
