<div>
    <div class="row mb-2">
        <div class="col-md-9">
            <label for="">Search</label>
            <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter Product name">
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
                        {{-- <th width="5%">Image</th> --}}
                        <th>Name</th>
                        <th width="10%">Price</th>
                        <th width="13%">SKU</th>
                        <th width="13%">Brand</th>
                        <th width="16%">Created at</th>
                        <th width="12%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        @if ($product->businessID == Auth::user()->businessID)
                            <tr>
                                <td>{!! $key + 1 !!}</td>
                                {{-- <td>
                           <center>
                              @if (Finance::check_product_image($product->proID) == 1)
                                 <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/finance/products/'.Finance::product_image($product->proID)->file_name) !!}" width="80px" height="60px">
                              @else
                                 <img src="{!! asset('assets/img/product_placeholder.jpg') !!}" width="80px" height="60px">
                              @endif
                           </center>
                        </td> --}}
                                <td>{!! $product->product_name !!}</td>
                                <td>
                                    ksh{!! number_format($product->price) !!}
                                </td>
                                <td>{!! $product->sku_code !!}</td>

                                <td>
                                    {!! $product->brand !!}
                                </td>
                                <td>{!! date('F d, Y', strtotime($product->date)) !!}</td>
                                <td>
                                    {{-- <a href="{{ route('products.details', $product->proID) }}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a> --}}
                                    <div class="d-flex" style="gap: 20px">
                                        <a href="{{ route('products.edit', $product->proID) }}"
                                            class="btn btn-primary btn-sm">
                                            <span>Edit</span>
                                        </a>
                                        <a href="{!! route('products.destroy', $product->proID) !!}" class="btn btn-danger delete btn-sm">
                                          <span>DELETE</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="mt-1">{!! $products->links() !!}</div>
        </div>
    </div>
</div>
