<section>
   <div class="card">
       <h5 class="card-header">Search Filter</h5>
       <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50">
           <div class="col-md-4 user_role">
               <div class="ml-2 input-group input-group-merge">
                   <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon"
                       placeholder="Search" />
               </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">
                   <label for="selectSmall">Select Per Page</label>
                   <select wire:model='perPage' class="form-control form-control-sm" id="selectSmall">
                       <option value="10">10</option>
                       <option value="20">20</option>
                       <option value="50">50</option>
                       <option value="100">100</option>
                   </select>
               </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">
                   <label for="selectSmall">Sort</label>
                   <select wire:model="sortAsc" class="form-control form-control-sm" id="selectSmall">
                       <option value="1">Ascending</option>
                       <option value="0">Descending</option>
                   </select>
               </div>
           </div>
           <div class="col-md-3">
               <div>
                   @if ($bulkDisabled)
                       <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#danger">
                           <span>Notify</span>
                       </button>
                   @else
                       <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#success">
                           <span>Notify</span>
                       </button>
                   @endif
               </div>
           </div>
       </div>
   </div>
   <!-- users filter end -->
   {{-- @include('partials.loaderstyle') --}}
   <!-- list section start -->
   <div class="card">
       <div class="pt-0 card-datatable table-responsive">
           <div class="card-datatable table-responsive">
               <table class="table table-striped table-bordered">
                   <thead>
                       <tr>
                           <th width="1%">#</th>
                           <th width="5%"></th>
                           <th>Name</th>
                           <th>Phone</th>
                           <th>Status</th>
                           <th width="12%">Approval</th>
                       </tr>
                   </thead>
                   <tbody>
                       @forelse ($users as $key => $user)
                           @if ($user->businessID == Auth::user()->businessID)
                               <tr>
                                   <td>{!! $key + 1 !!}</td>
                                   <td>
                                       <div class="custom-control custom-control-success custom-checkbox">
                                           <input wire:model="selectedData" value="{{ $user->id }}" type="checkbox"
                                               class="custom-control-input" id="colorCheck3{{ $user->id }}" />
                                           <label class="custom-control-label"
                                               for="colorCheck3{{ $user->id }}"></label>
                                       </div>
                                   </td>
                                   <td>{{ $user->name }}</td>
                                   <td>{{ $user->phone_number }}</td>
                                   <td>{{ $user->status ?? "Active"}}</td>
                                   <td>{{ $user->approval ?? "Approved"}}</td>
                               </tr>
                           @endif
                       @empty
                           <tr>
                               <x-emptyrow>
                                   8
                               </x-emptyrow>
                           </tr>
                       @endforelse
                   </tbody>
               </table>
               <div class="mt-1"></div>
               {{ $users->links() }}
           </div>
       </div>
       <!-- Modal to add new user starts-->
       @include('livewire.notification.customers.modal')
       <!-- Modal to add new user Ends-->
   </div>
   <!-- list section end -->
   {{-- @include('partials.loaderscript') --}}
</section>
