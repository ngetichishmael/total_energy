<div>
   <div class="row mb-2">
       <div class="col-md-9">
           <label for="">Search</label>
           <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Search ..">
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
