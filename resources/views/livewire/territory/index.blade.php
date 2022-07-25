<div>
   <div class="row">
      <div class="col-md-6">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title">Your territory</h4>
            </div>
            <div class="card-body">
               <div id="jstree-basicd">
                  <ul>
                     @foreach($territories as $territory)
                        <li data-jstree='{"icon" : "far fa-folder"}'>
                           {!! $territory->name !!}
                           <ul>
                              @foreach(Sales::child_territory($territory->code) as $child)
                                 <li data-jstree='{"icon" : "fa fa-dot-circle"}'>{!! $child->name !!}</li>
                                 <ul>
                                    @foreach(Sales::child_territory($child->code) as $chil2)
                                       <li data-jstree='{"icon" : "fa fa-dot-circle"}'>{!! $chil2->name !!}</li>
                                    @endforeach
                                 </ul>
                              @endforeach
                           </ul>
                        </li>
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <!--/ Basic Tree -->
      <div class="col-md-6">
         <div class="card card-default">
            <div class="card-body">
               <h4 class="card-title">Add Territory</h4>
               <div class="form-group form-group-default required mb-1">
                  {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                  <input type="text" wire:model="name" class="form-control" placeholder="Enter Name" required>
                  @error('name')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group form-group-default required mb-1">
                  {!! Form::label('name', 'Choose parent territory', array('class'=>'control-label')) !!}
                  <select wire:model="parent_territory" class="form-control">
                     <option value="">Choose</option>
                     @foreach($parents as $parent)
                        <option value="{!! $parent->code !!}">{!! $parent->name !!}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group form-group-default required">
                  {!! Form::label('name', 'Choose status', array('class'=>'control-label')) !!}
                  <select class="form-control" wire:model="status" required>
                     <option value="">Choose</option>
                     <option value="Active">Active</option>
                     <option value="Closed">Closed</option>
                  </select>
                  @error('status')<span class="error text-danger">{{$message}}</span>@enderror
               </div>
               <div class="form-group mt-4">
                  <center>
                     <button type="submit" class="btn btn-success" wire:click.prevent="add_territory()"><i class="fas fa-save"></i> Save Information</button>
                  </center>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
