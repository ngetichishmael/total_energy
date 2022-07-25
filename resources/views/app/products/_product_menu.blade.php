<!-- shop menu -->
<div class="col-md-3">
   <div class="card card-white">
      <div class="card-body">
         <div class="nav flex-column nav-pills">
            <a class="nav-link {{ Nav::isRoute('products.edit') }}" href="{!! route('products.edit',$productID) !!}">Information</a>
            <a class="nav-link {{ Nav::isResource('price') }}" href="{!! route('product.price', $productID) !!}">Price</a>
            <a class="nav-link {{ Nav::isResource('inventory') }}" href="{!! route('products.inventory', $productID) !!}">Inventory</a>
          </div>
      </div>
   </div>
</div>
