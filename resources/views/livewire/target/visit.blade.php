<div>
   <div class="row mb-2">

       <div class="col-md-9">
           <label for="">Search</label>
           <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Search ...">
           <!-- Button trigger modal -->
           <div class="mt-1">
               <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                   New Target
               </button>
           </div>
       </div>
       <div class="col-md-3">
           <label for="">Items Per</label>
           <select wire:model="perPage" class="form-control">`
               <option value="10" selected>10</option>
               <option value="25">25</option>
               <option value="50">50</option>
               <option value="100">100</option>
           </select>
       </div>
   </div>
   <div class="card card-default">
       <div class="card-body">
           <table class="table table-striped table-bordered">
               <thead>
                   <tr>
                       <th width="1%">#</th>
                       <th>Sales Person</th>
                       <th>Target</th>
                       <th>Achieved</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td>1</td>
                       <td>hello World</td>
                       <td>hello World</td>
                       <td>hello World</td>
                   </tr>

               </tbody>
           </table>
       </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
               ...
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary">Save changes</button>
           </div>
       </div>
   </div>
</div>
