<div class="card card-statistics">
    <div class="card-header">
        <h4 class="card-title">Top Product Value</h4>
        <div class="d-flex align-items-center">
            <p class="mb-0 card-text font-small-2 mr-25">Default Shows Monthly Report</p>
        </div>
    </div>
    <div class="card">
        <div class="mt-0 card-body statistics-body">
            <div class="row">
                @php $avatarIcons = ['inventory', ' check_circle', 'inventory', 'order_approve', ' check_circle', 'order_approve']; @endphp

                @foreach ($topproducts as $index => $product)
                    @php $avatarIndex = $index % count($avatarIcons); @endphp

                    <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                        <a href="#salesSection" class="d-flex align-items-center">
                            <div class="avatar bg-light-warning">
                                <div class="avatar-content">
                                    <span class="material-symbols-outlined">{{ $avatarIcons[$avatarIndex] }}</span>
                                </div>
                            </div> &nbsp;&nbsp;
                            <div class="pl-3 my-auto ml-3 media-body">
                                <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                    &nbsp; {{ $product->total_quantity }} </h4>
                                <p class="mb-0 card-text font-small-3 font-medium-1" style="color: rgba(71,75,79,0.76)">
                                    {{ Str::limit($product->product_name, 15) }} ({{ $product->sku_code }})
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
