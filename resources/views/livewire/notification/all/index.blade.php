<section class="app-user-list">
    <!-- users filter start -->
    <div class="card">
        <h5 class="card-header">Search Filter</h5>
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50">
            <div class="col-md-4 user_role">
                <div class="ml-3 input-group input-group-merge">
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
                        <option value="500">500</option>
                        <option value="1000">1000</option>
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
        </div>
    </div>
    <!-- users filter end -->
    <!-- list section start -->
    <div class="card" wire:loading.remove>
        <div class="pt-0 card-datatable table-responsive">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notifications as $notification)
                        <tr>
                            <th scope="row"></th>
                            <th scope="row">{{ $notification->id }}</th>
                            <td>{{ $notification->name }}</td>
                            <td>{{ $notification->title }}</td>
                            <td>{{ $notification->body }}</td>
                            <td>{{ $notification->date }}</td>
                            <td>
                                @if ($notification->status === '1')
                                    <div class="d-flex" style="gap:2px;">
                                       <a href="#" class="btn btn-danger btn-sm">Close</a>
                                   </div>
                                @else
                                <div class="d-flex" style="gap:2px;">
                                 <a href="#" class="btn btn-success btn-sm">Active</a>
                             </div>
                                @endif
                            </td>

                        @empty

                        </tr>
                        <x-emptyrow>
                            8
                        </x-emptyrow>
                    @endforelse
                </tbody>
            </table>
            {{ $notifications->links() }}
        </div>
        <!-- Modal to add new user starts-->
        {{-- @include('livewire.area.modal') --}}
        <!-- Modal to add new user Ends-->
    </div>
    <!-- list section end -->
</section>
{{-- @include('partials.loaderscript') --}}
