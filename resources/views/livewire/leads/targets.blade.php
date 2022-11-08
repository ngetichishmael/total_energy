<div>
   <div class="col-lg-12 col-12">
       <div class="card">
           <h5 class="card-header">Assign QPs Target</h5>
       </div>
       <div class="card">
           <div class="card-body p-0">
               <div>
                   <table class="table">
                       <thead class="thead-light">
                           <tr>
                               <th>Managers</th>
                               <th>Target</th>
                               <th>Action</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($QPTargets as $index => $target)
                               <tr class="col-12">
                                   <td>
                                       <select wire:model="QPTargets.{{ $index }}.primarykey"
                                           class="form-control
                                           @error('QPTargets.{{ $index }}.primarykey')
                                           border border-danger
                                           @enderror ">
                                           <option value=""> -- choose Manager-- </option>
                                           <option value="ALL">ALL</option>
                                           @foreach ($managers as $manager)
                                               <option value="{{ $manager->primarykey }}">
                                                   {{ $manager->Name }}
                                               </option>
                                           @endforeach
                                       </select>
                                       @error('QPTargets.{{ $index }}.primarykey')
                                           <span class="error">{{ $message }}</span>
                                       @enderror
                                   </td>
                                   <td>
                                       <input type="number" class="form-control"
                                           wire:model.prevent="QPTargets.{{ $index }}.Target" />
                                       @error('QPTargets.{{ $index }}.Target')
                                           <span class="error">{{ $message }}</span>
                                       @enderror
                                   </td>
                                   <td>
                                       <a type="button" class="btn btn-outline-danger" href="#"
                                           wire:click="removeQPTargets({{ $index }})">
                                           <i data-feather="trash-2" class="mr-25"></i>
                                           <span>Delete</span>
                                       </a>
                                   </td>
                               </tr>
                           @endforeach
                       </tbody>
                   </table>
                   <div class="row">
                       <div class="col-md-12 m-2">
                           <button wire:click.prevent="addQPTargets" type="button" class="btn btn-outline-primary">
                               <i data-feather="user-plus" class="mr-25"></i>
                               <span>Add New Row</span>
                           </button>
                       </div>
                   </div>
               </div>

               @error('QPTargets.{{ $index }}.primarykey')
                   <span class="error">{{ $message }}</span>
               @enderror
               @if ($countQPTargets)
                   <div class="m-2">
                       <button wire:click.prevent="submitQP()" type="submit"
                           class="btn btn-primary mr-1 data-submit">Submit</button>
                   </div>
               @else
                   <div class="m-2">
                       <button class="btn btn-outline-primary">DISABLED</button>
                   </div>
               @endif
           </div>
       </div>
   </div>
</div>
