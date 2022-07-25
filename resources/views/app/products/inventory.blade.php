@extends('layouts.app')
{{-- page header --}}
@section('title','Product Inventory')

{{-- content section --}}
@section('content')
<div class="row">
   @include('app.products._product_menu')
   <div class="col-md-9">
      {{-- <div class="card card-default">
         <div class="card-body">
            <div class="col-md-12 mt-3">
               {!! Form::model($product, ['route' => ['products.inventory.settings.update',$productID], 'class' => 'row', 'method'=>'post','enctype'=>'multipart/form-data']) !!}
                  @csrf
                  <div class="col-md-6">
                     <h5>Track inventory for this product</h5>
                     <p>Would you like winguplus to track inventory movement for this product?</p>
                     <div class="form-group required">
                        {!! Form::select('track_inventory',[''=>'Choose','Yes' => 'Yes','No' => 'No'],null,['class' => 'form-control multiselect']) !!}
                     </div>
                  </div>
                  <div class="col-md-12 mt-1">
                     <button type="submit" class="btn btn-success float-left"><i class="fas fa-save"></i> Update</button>
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
      </div> --}}
      @if($product->track_inventory == "Yes")
         <div class="card card-default">
            <div class="card-body">
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-12">
                        <h4 class="card-title mb-1">Inventory</h4>
                        <table class="table table-striped">
                           <thead>
                              {{-- <th width="25%">Out Let</th> --}}
                              <th>Available stock</th>
                              <th>Reorder point</th>
                              <th>Reorder Qty</th>
                              {{-- <th>Expiration Date</th> --}}
                              <th width="13%"></th>
                           </thead>
                           <tbody>
                              <form action="{!! route('products.inventory.update',$productID) !!}" method="POST" >
                                 @csrf
                                 <tr>
                                    {{-- <td>
                                       @if($inventory->default_inventory == 'Yes')
                                          {!! $mainBranch->branch_name !!}
                                       @else
                                          @if(Hr::check_branch($inventory->branch_id) == 1)
                                             {!! Hr::branch($inventory->branch_id)->branch_name !!}
                                          @endif
                                       @endif
                                    </td> --}}
                                    <td><input type="text" class="form-control" name="current_stock" value="{!! $defaultInventory->current_stock !!}"></td>
                                    <td><input type="text" class="form-control" name="reorder_point" value="{!! $defaultInventory->reorder_point !!}"> </td>
                                    <td><input type="text" class="form-control" name="reorder_qty" value="{!! $defaultInventory->reorder_qty !!}"> </td>
                                    {{-- <td><input type="date" class="form-control" name="expiration_date" value="{!! $defaultInventory->expiration_date !!}"> </td> --}}
                                    <td>
                                       <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                       {{-- <a href="{!! route('products.inventory.outlet.link.delete',[$productID,$inventory->branch_id]) !!}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a> --}}
                                       {{-- @if($inventory->default_inventory != 'Yes')
                                          @if(Hr::check_branch($inventory->branch_id) == 1)
                                             <a href="{!! route('products.inventory.outlet.link.delete',[$productID,$inventory->branch_id]) !!}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a>
                                          @endif
                                       @endif --}}
                                    </td>
                                 </tr>
                              </form>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      @endif
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Outlet </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="{!! route('products.inventory.outlet.link') !!}" method="post" enctype="multipart/form-data">
               @csrf
               <div class="form-group">
                  <label for="">Choose Outlet</label>
                  <select name="outlets[]" id="" class="form-control" multiple required style="width:100%">
                     @foreach($outlets as $outlet)
                        @if($mainBranch->id != $outlet->id)
                           <option value="{!! $outlet->id !!}">{!! $outlet->branch_name !!}</option>
                        @endif
                     @endforeach
                  </select>
                  <input type="hidden" name="productID" value="{!! $productID !!}" required>
               </div>
               <div class="form-group">
                  <center><button class="btn btn-success btn-sm">Add Outlets</button></center>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
