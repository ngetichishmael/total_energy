@extends('layouts.app')
{{-- page header --}}
@section('title')
	LPO | {!! $lpo->prefix !!}{!! $lpo->number !!}
@endsection

@section('stylesheet') 
	<style>
		body {
			background: #FFFF;
			}
	</style>
@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		@include('partials._messages')
		<div class="row">
			<div class="col-md-6">
				<a href="#"  class="btn {!! Wingu::status($lpo->statusID)->name !!} mb-2"><i class="fas fa-bell"></i> {!! ucfirst(Wingu::status($lpo->statusID)->name) !!}</a>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-8">
						<a href="{!! route('finance.stock.mail', $lpo->lpoID) !!}" class="btn btn-sm btn-default m-b-10 p-l-5">
							<i class="fas fa-envelope"></i> Email
						</a>
						<a href="{!! route('finance.product.stock.order.edit', $lpo->lpoID) !!}" class="btn btn-sm btn-default m-b-10 p-l-5">
							<i class="fas fa-edit"></i> Edit
						</a>
						<a href="{!! route('finance.product.stock.order.pdf', $lpo->lpoID) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
							<i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
						</a>
						<a href="{!! route('finance.product.stock.order.print', $lpo->lpoID) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
							<i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print
						</a>
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								More
							</button>
							<ul class="dropdown-menu dropdown-menu-right">
								{{-- <li><a href="{!! url('/') !!}/storage/files/finance/lpo/{!! $lpo->file !!}" target="_blank">View LPO as customer</a></li> --}}
								<li><a href="#" data-toggle="modal" data-target="#attach-files">Attach Files</a></li>
								@if($lpo->statusID != 10)
									<li><a href="{!! route('finance.lpo.status.change',[$lpo->lpoID,10]) !!}">Mark as Draft</a></li>
								@endif
								@if($lpo->statusID != 11)
								<li><a href="{!! route('finance.lpo.status.change',[$lpo->lpoID,11]) !!}">Mark as Expired</a></li>
								@endif
								@if($lpo->statusID != 12)
								<li><a href="{!! route('finance.lpo.status.change',[$lpo->lpoID,12]) !!}">Mark as Declined</a></li>
								@endif
								@if($lpo->statusID != 13)
								<li><a href="{!! route('finance.lpo.status.change',[$lpo->lpoID,13]) !!}">Mark as Accepted</a></li>
								@endif
								@if($lpo->statusID != 6)
								<li><a href="{!! route('finance.lpo.status.change',[$lpo->lpoID,6]) !!}">Mark as Sent</a></li>
								@endif
								@if($lpo->statusID != 14)
								<li><a href="{!! route('finance.stock.delivered',[$lpo->lpoID]) !!}">Mark as Delivered</a></li>
								@endif
								<li class="divider"></li>
								@permission('delete-stockcontrol')
								<li><a href="{!! route('finance.lpo.delete',$lpo->lpoID) !!}" class="text-danger">Delete LPO</a></li>
								@endpermission
							</ul>
						</div>
					</div>
				</div>				
			</div>
		</div>
		@include('templates.'.$template.'.lpo.preview')
	</div>

	{{-- attach files to Quotes --}}
	<div class="modal fade" id="attach-files">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Attachment</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="{!! route('finance.stock.attach') !!}" class="dropzone" id="my-awesome-dropzone" method="post">
						@csrf()
						<input type="hidden" value="{!! $lpo->lpoID !!}" name="lpoID">
					</form>
					<center><h3 class="mt-5">Attachment Files</h3></center>
					<div class="row">
						<div class="col-md-12">
						<table id="data-table-default" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="1%">#</th>
									<th></th>
									<th width="10%">Name</th> 
									<th>Type</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($files as $file)
									<tr>
										<td>{!! $filec++ !!}</td>
										<td>
											@if(stripos($file->file_mime, 'image') !== FALSE)
												<center><i class="fas fa-image fa-4x"></i></center>
											@endif
											@if(stripos($file->file_mime, 'pdf') !== FALSE)
												<center><i class="fas fa-file-pdf fa-4x"></i></center>
											@endif
											@if(stripos($file->file_mime, 'octet-stream') !== FALSE)
												<center><i class="fas fa-file-alt fa-4x"></i></center>
											@endif
										</td>
										<td width="10%">{!! $file->file_name !!}</td>
										<td>{!! $file->file_mime !!}</td>
										
										<td>
											<a href="{!! route('finance.lpo.attachment.delete',$file->id) !!}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')
	<script>
		function change_status() {
			var url = '{!! url('/') !!}';
			var status = document.getElementById("status").value;
			var file = document.getElementById("fileID").value;
			$.get(url+'/finance/lpo/file/'+status+'/'+file, function(data){
				//success data
				location.reload();
			});
		}
	</script>
@endsection
