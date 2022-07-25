<div class="modal fade" id="taxRate" tabindex="-1" role="dialog" aria-labelledby="taxRate" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form id="taxrateForm" action="javascript:void(0)" autocomplete="off">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="taxRate">Add Tax Rate</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               @csrf
               <div class="form-group">
                  <label for="">Tax Name</label>
                  <input type="text" name="tax_name" id="taxName" class="form-control" placeholder="Enter name">
               </div>
               <div class="form-group">
                  <label for="">Tax Rate</label>
                  <input type="number" step="0.01" name="rate" id="rate" class="form-control" placeholder="Enter rate" required>
               </div>
            </div>	
            <div class="modal-footer">
               <button type="submit" id="saveRate" class="btn btn-success">Add Tax</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
            </div>
         </div>
      </form>
   </div>
 </div>