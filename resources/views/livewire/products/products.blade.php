<div>
<div class="card">
            <h5 class="card-header"></h5>
            <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                <div class="col-md-4 user_role">
                    <div class="input-group input-group-merge">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="search"></i></span>
                        </div>
                        <input  wire:model.debounce.300ms="search" type="text" id="fname-icon" class="form-control" name="fname-icon" placeholder="Search" />
                    </div>
                </div>
                <div class="col-md-2 user_role">
                    <div class="form-group">
                        <label for="selectSmall">Per Page</label>
                        <select wire:model="perPage" class="form-control form-control-sm" id="selectSmall">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
       

             <div class="col-md-3">
                 <a href="{!! route('products.create') !!}" class="btn btn-success btn-sm"><i class="fa fa-user-plus"></i> Add New Customer</a>
                 <a href="{!! route('products.import') !!}" class="btn btn-warning btn-sm"><i class="fa fa-file-upload"></i> Import </a>
             </div>
             
            </div>
        </div>


    <div class="card card-default">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="1%">#</th>
                        {{-- <th width="5%">Image</th> --}}
                        <th>Name</th>
                        <th>Price</th>
                        <th >SKU</th>
                        <th>Brand</th>
                         <th width="16%"> Status</th>  
                        <th >Actions</th>
                    </tr>
                </thead>
                <tbody>
                 @forelse ($products as $key => $product)
                        <tr>
                            <td>{!! $key + 1 !!}</td>
                            <td>{!! $product->product_name !!}</td>
                            <td>
                                ksh:
                                {{ number_format((float) $product->ProductPrice()->pluck('selling_price')->implode('')) }}
                            </td>
                            <td>{!! $product->sku_code !!}</td>

                            <td>
                                {!! $product->brand !!}
                            </td>
                            
                            <td>
                                @if ($product->status === 1)
                                <span class="badge badge-pill badge-light-success mr-1">Active</span>
                                @else
                                    <span class="badge badge-pill badge-light-warning mr-1">Diasbled</span>
                                @endif
                            </td> 
                            <td>

                              <div class="dropdown">
                                    <button class="btn btn dropdown-toggle mr-2" style="background-color:#4395d1; color:#ffffff; padding: 6px 14px; font-size: 12px;" type="button" id="dropdownMenuButton" data-bs-trigger="click" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                        <i data-feather="eye"></i>
                                    </button>

                                        <div class="dropdown-menu">
                                        
                                            <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">
                                                <i data-feather="edit" class="mr-50"></i>
                                                <span>Edit</span>
                                            </a>
                                            @if ($product->status === 1)
                                                <a wire:click.prevent="deactivate({{ $product->id }})"
                                                    onclick="return confirm('Are you sure you want to disable this product?')"
                                                    class="dropdown-item">
                                                    <i data-feather="check-circle" class="mr-50"></i>
                                                    <span>Disable</span>
                                                </a>
                                            @else
                                                <a wire:click.prevent="activate({{ $product->id }})"
                                                    onclick="return confirm('Are you sure you want to activate this product?')"
                                                    class="dropdown-item">
                                                    <i data-feather="x-circle" class="mr-50"></i>
                                                    <span>Activate</span>
                                                </a>
                                            @endif
                                         

                                        </div>
                                    </div>
                            </td>
                        </tr>
                        @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; ">No Record Found</td>
                                </tr>
                        @endforelse
                </tbody>
            </table>
            <div class="mt-1">{!! $products->links() !!}</div>
        </div>
    </div>
</div>
