<div>
   <div class="row">
      <div class="col-md-8">
         <div class="card">
            <div class="card-header"> Allocated Items</div>
            <div class="card-body">
               <table class="table table-bordered table-striped">
                  <thead>
                     <th>#</th>
                     <th>Product</th>
                     <th>Current Qty</th>
                     <th>Allocated Qty</th>
                     <th>Returned Qty</th>
                  </thead>
                  <tbody>
                     @foreach($allocatedItems as $count=>$item)
                        <tr>
                           <td>{!! $count+1 !!}</td>
                           <td>{!! $item->product_name !!}</td>
                           <td>{!! $item->current_qty !!}</td>
                           <td>{!! $item->allocated_qty !!}</td>
                           <td>{!! $item->returned_qty !!}</td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="col-md-4">
         <div class="card">
            <div class="card-header"> Add Items</div>
            <div class="card-body">
               <div class="form-group">
                  <label for="">Products</label>
                  <select class="form-control" id="product" wire:model="product" required>
                     <option value="">Choose product</option>
                     @foreach($products as $prod)
                        <option value="{!! $prod->id !!}">{!! $prod->product_name !!}</option>
                     @endforeach
                  </select>
               </div>
               @if($inventoryQuantity > 0)
                  <h5 class="mt-2">Available Items : {!! $inventoryQuantity !!}</h5>
                  <div class="form-group mt-2">
                     <label for="">Quantity</label>
                     <input type="number" class="form-control" wire:model="quantity" required>
                  </div>
                  <div class="form-group mt-2">
                     <button wire:click.prevent="allocate_item()" class="btn btn-success"><i class="fa fa-save"></i> Allocate Product</button>
                  </div>
               @else
                  <h4 class="text-center mt-3">No available stock</h4>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
