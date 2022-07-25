@extends('layouts.app')
{{-- page header --}}
@section('title','Mail LPO')
{{-- page styles --}}
@section('stylesheet')
@endsection
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('finance.product.stock.order.show',$lpo->lpoID) !!}" class="btn btn-pink"><i class="fas fa-chevron-left"></i> Back to view</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Mail LPO To {!! $lpo->supplierName !!}</h1>
		@include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <form class="" action="{!! route('finance.stock.mail.send') !!}" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="lpoID" value="{!! $lpo->lpoID !!}" required>
                     @csrf
                     <div class="form-group col-md-12">
   							<label for="">Form</label>
   							<input type="email" name="email_from" value="{!! $lpo->primary_email !!}" class="form-control">
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Send To</label>
                        <input type="text" name="send_to" value="{!! $supplier->email !!}" class="form-control" required readonly>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Cc</label>
                        <select name="email_cc[]" id="" class="form-control multiselect" style="width:100%" multiple>
                           @if($lpo->email_cc != "")
   								   <option value="{!! $supplier->emailCC !!}">{!! $supplier->emailCC !!}</option>
                           @endif
   								@foreach ($contacts as $contact)
   									<option value="{!! $contact->contact_email !!}">{!! $contact->contact_email !!}</option>
   								@endforeach
   							</select>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Subject</label>
   							<input type="text" name="subject" value="{!! $lpo->prefix !!}{!! $lpo->lpo_number !!}  is awaiting your approval" class="form-control" required>
   						</div>
   						<div class="form-group col-md-12">
   							<textarea name="message" cols="30" rows="10" class="ckeditor" required>
   								<span style="font-size: 12pt;font-weight: 900">Dear {!! $supplier->supplierName !!}</span>
                           <br/><br/>
                           <span style="font-size: 12pt;">Please find the attached LPO <strong># {!! $lpo->prefix !!}{!! $lpo->lpo_number !!}</strong></span>
                           <br/><br/>
                           <span style="font-size: 12pt;"><strong>LPO status:</strong> <em>{!! $lpo->statusName !!}</em></span>
                           <br/><br/>
                           <span style="font-size: 12pt;">We look forward to your communication.</span>
                           <br/><br/>
                           <span style="font-size: 12pt;">Kind Regards,</span>
                           <br/>
                           <span style="font-size: 12pt;">
                              <b>
                                 {!! $lpo->businessName !!}
                              </b>
									</span>
   							</textarea>
   						</div>
   						<div class="form-group mt-3">
	   						<a href="{!! asset('businesses/'.$lpo->primary_email.'/finance/lpo/'.$lpo->prefix.$lpo->lpo_number) !!}.pdf" target="_blank" class="ml-3" id="preview"> Preview Attached LPO</a>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Attach Files</label>
   							<select name="attach_files[]" class="form-control multiselect" style="width:100%" multiple>
   								@foreach ($files as $file)
   									<option value="{!! $file->id !!}">{!! $file->file_name !!}</option>
   								@endforeach
   							</select>
   						</div>
                     <div class="form-group mt-5">
                        <button type="submit" name="button" class="offset-md-10 btn btn-pink submit"><i class="fas fa-paper-plane"></i> Send LPO</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script src="{!! url('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
