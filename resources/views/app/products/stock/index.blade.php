@extends('layouts.app')
{{-- page header --}}
@section('title','Stock Control')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
			@if(Finance::lpo_count() != Wingu::plan()->lpos && Finance::lpo_count() < Wingu::plan()->lpos)
				@permission('create-stockcontrol')
					<a href="{!! route('finance.product.stock.order') !!}" class="btn btn-pink"> Order stock</a>
				@endpermission
			@endif
         {{-- <a href="#" class="btn btn-pink"> Return stock</a>
         <a href="#" class="btn btn-pink"> Inventory Count</a>
         <a href="#" class="btn btn-pink"> Transfer stock</a> --}}
		</div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-boxes"></i> Stock Control  </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
		<div class="panel panel-default mt-4">
			<div class="panel-heading">
				<h4 class="panel-title">All Orders</h4>
			</div>
			<div class="panel-body">
				<table id="data-table-default" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th width="1%">#</th>
							<th>Number</th>
							<th>Supplier</th>
							<th>Reference #</th>
							<th>Items</th>
							<th>Total Cost</th>
							<th>Status</th>
							<th>Date Created</th>
							<th width="10%">Action</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th width="1%">#</th>
							<th>Number</th>
							<th>Supplier</th>
							<th>Reference #</th>
							<th>Items</th>
							<th>Total Cost</th>
							<th>Status</th>
							<th>Date Created</th>
							<th width="10%">Action</th>
						</tr>
					</tfoot>
					<tbody>
						@foreach ($lpos as $crt => $v)
							<tr role="row" class="odd">
								<td>{{ $crt+1 }}</td>
								<td>
									<b>{!! $v->prefix !!}{!! $v->lpo_number !!}</b>
								</td>
								<td>
									{!! $v->supplierName !!}
								</td>
								<td class="text-uppercase font-weight-bold">
									{!! $v->reference_number !!}
								</td>
								<td>{!! Finance::lpo_items($v->lpoID) !!}</td>
								<td>{!! $v->code !!} {!! number_format($v->total) !!}</td>
								<td><span class="badge {!! $v->statusName !!}">{!! ucfirst($v->statusName) !!}</span></td>
								<td>
									{!! date('F j, Y',strtotime($v->lpo_date)) !!}
								</td>
								<td>
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
										<ul class="dropdown-menu">
											@permission('read-stockcontrol')
												<li><a href="{{ route('finance.product.stock.order.show', $v->lpoID) }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
											@endpermission
											@permission('update-stockcontrol')
												<li><a href="{!! route('finance.product.stock.order.edit', $v->lpoID) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
											@endpermission
											@permission('delete-stockcontrol')
												<li><a href="{!! route('finance.lpo.delete', $v->lpoID) !!}"><i class="fas fa-trash-alt delete"></i>&nbsp;&nbsp; Delete</a></li>
											@endpermission
										</ul>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
	    	</div>
	   </div>
	</div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
