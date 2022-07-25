@extends('layouts.app')
{{-- page header --}}
@section('title','Tax Rates')
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
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item active">Tax Rates</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-coins"></i> Tax Rates</h1>
      @include('partials._messages')
      <div class="row">
         @include('app.finance.partials._settings_nav')
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        <a href="#add-currency" class="btn btn-pink mb-3" data-toggle="modal"><i class="fas fa-plus"></i> Add Tax Rates</a>
                        <table id="data-table-default" class="table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Tax</th>
                                 <th>Rate</th>
                                 <th>Compound</th>
                                 <th>Description</th>
                                 <th width="20%">Action</th>
                              </tr>
                           </thead>
                           <tfoot>
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Tax</th>
                                 <th>Rate</th>
                                 <th>Compound</th>
                                 <th>Description</th>
                                 <th width="20%">Action</th>
                              </tr>
                           </tfoot>
                           <tbody>
                              @foreach ($taxes as $tax)
                                 <tr>
                                    <td>{!! $count++ !!}</td>
                                    <td>{!! $tax->name !!}</td>
                                    <td>{!! $tax->rate !!}%</td>
                                    <td>{!! $tax->compound !!}</td>
                                    <td>{!! $tax->description !!}</td>
                                    <td>
                                       @permission('update-taxes')
                                          <a href="javascript:;" class="btn btn-sm btn-primary edit-taxes" id="{!! $tax->id !!}"><i class="fas fa-edit"></i> Edit</a>
                                       @endpermission
                                       @permission('delete-taxes')
                                          <a href="{!! route('finance.settings.delete', $tax->id) !!}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                                       @endpermission
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="add-currency">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Add Tax Rates</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <form action="{!! route('finance.settings.taxes.store') !!}" method="POST">
                  @csrf
                  <div class="form-group">
                     <label for="">Tax Name</label>
                     <input type="text" class="form-control" name="tax_name" required>
                  </div>
                  <div class="form-group">
                     <label for="">Tax Rates</label>
                     <input type="number" class="form-control" name="tax_rate" required>
                  </div>
                  <div class="form-group">
                     <label for="">Tax Descriptions</label>
                     <textarea type="text" class="form-control" name="description"></textarea>
                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit">Submit</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
               <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Close</a>
            </div>
         </div>
      </div>
   </div>

   <!-- #modal-dialog -->
   <div class="modal fade" id="edit-taxes" tabindex="-1" role="dialog">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Update Tax Rates</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               {!! Form::open(array('route' => 'finance.settings.update','post','autocomplete'=>'off')) !!}  
                  {!! csrf_field() !!}
                  <div class="form-group">
                     <label for="">Tax Name</label>
                     {!! Form::text('name', null, array('class' => 'form-control', 'id' => 'name', 'required' => '')) !!}
                     <input type="hidden" name="taxID" id="taxID">
                  </div>
                  <div class="form-group">
                     <label for="">Tax Rates</label>
                     {!! Form::number('rate', null, array('class' => 'form-control', 'id' => 'rate', 'required' => '')) !!}
                  </div>
                  <div class="form-group">
                     <label for="">Tax Descriptions</label>
                     {!! Form::textarea('description', null, array('class' => 'form-control','id' => 'description')) !!}
                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit">Update Tax Rate</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
   <!-- #modal-without-animation -->
@endsection
@section('scripts')
   <script>
      $(document).on('click', '.edit-taxes', function(){    
         var id = $(this).attr('id');
			var url = "{!! url('/') !!}";
         $('#edit-taxes').html();
         $.ajax({
            url: url+"/finance/settings/taxes/"+id+"/edit",
            dataType:"json",
            success:function(html){
               $('#name').val(html.data.name);
               $('#rate').val(html.data.rate);
					$('#description').val(html.data.description);
					$('#taxID').val(id);
               $('#edit-taxes').modal('show');
            }
         })
      });
   </script>
@endsection

