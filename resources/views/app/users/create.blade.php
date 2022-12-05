@extends('layouts.app')
{{-- page header --}}
@section('title','Create User')
{{-- page styles --}}
@section('stylesheets')

@endsection


{{-- content section --}}
@section('content')
   <!-- begin breadcrumb -->

   <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-2">
         <div class="row breadcrumbs-top">
            <div class="col-12">
               <h2 class="content-header-title float-start mb-0">Users </h2>
               <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="#">Home</a></li>
                     <li class="breadcrumb-item"><a href="#">Users</a></li>
                     <li class="breadcrumb-item active">Create</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-8">
         <div class="card">
            <div class="card-body">
               <form class="row" method="POST" action="{!! route('user.store') !!}">
                  @csrf
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Name <span class="text-danger">*</span></label>
                     {!! Form::text('name',null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Email <span class="text-danger">*</span></label>
                     {!! Form::email('email',null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">Phone Number <span class="text-danger">*</span></label>
                     {!! Form::number('phone_number',null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1 col-md-6">
                     <label for="">User Type <span class="text-danger">*</span></label>
                     {!! Form::select('account_type',[''=>'Choose','Sales' => 'Sales', 'Admin'=> 'Admin'],null,['class'=>'form-control']) !!}
                  </div>
                  <div class="form-group mb-1 col-md-12">
                     <center><button class="btn btn-success" type="submit">Save information</button></center>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <section class="app-user-edit">
      <div class="card">
          <div class="card-body">
              <div class="tab-content">
                  <!-- Account Tab starts -->
                  <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                      <form class="form-validate">
                          <div class="row">
                              <div class="col-12">
                                  <div class="table-responsive border rounded mt-1">
                                      <h6 class="py-1 mx-1 mb-0 font-medium-2">
                                          <i data-feather="lock" class="font-medium-3 mr-25"></i>
                                          <span class="align-middle">Permission</span>
                                      </h6>
                                      <table class="table table-striped table-borderless">
                                          <thead class="thead-light">
                                              <tr>
                                                  <th>Module</th>
                                                  <th>Permission</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <tr>
                                                  <td>Van Sales</td>
                                                  <td>
                                                      <div class="custom-control custom-checkbox">
                                                          <input type="checkbox" class="custom-control-input"
                                                              id="admin-read" />
                                                          <label class="custom-control-label" for="admin-read"></label>
                                                      </div>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td>New Sales</td>
                                                  <td>
                                                      <div class="custom-control custom-checkbox">
                                                          <input type="checkbox" class="custom-control-input"
                                                              id="staff-read" />
                                                          <label class="custom-control-label" for="staff-read"></label>
                                                      </div>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td>Deliveries</td>
                                                  <td>
                                                      <div class="custom-control custom-checkbox">
                                                          <input type="checkbox" class="custom-control-input"
                                                              id="author-read" />
                                                          <label class="custom-control-label" for="author-read"></label>
                                                      </div>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td>Schedule Visits</td>
                                                  <td>
                                                      <div class="custom-control custom-checkbox">
                                                          <input type="checkbox" class="custom-control-input"
                                                              id="contributor-read" />
                                                          <label class="custom-control-label"
                                                              for="contributor-read"></label>
                                                      </div>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td>Merchanizing</td>
                                                  <td>
                                                      <div class="custom-control custom-checkbox">
                                                          <input type="checkbox" class="custom-control-input"
                                                              id="user-read" />
                                                          <label class="custom-control-label" for="user-read"></label>
                                                      </div>
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                              <div class="col-12 d-flex flex-sm-row flex-column mt-2" style="gap: 20px;">
                                  <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Save
                                      Changes</button>
                                  <button type="reset" class="btn btn-outline-secondary">Reset</button>
                              </div>
                          </div>
                      </form>
                      <!-- users edit account form ends -->
                  </div>
                  <!-- Account Tab ends -->
              </div>
          </div>
      </div>
  </section>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
