<?php

namespace App\Http\Livewire\Products;

use App\Models\products\product_information;
use Livewire\Component;
// use Illuminate\Support\Facades\Auth as FacadesAuth;
use Livewire\WithPagination;
use Auth;

class Products extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public ?string $search = null;
   public $orderBy = 'id';
   public $orderAsc = true;

   public function render()
   {
      $searchTerm = '%' . $this->search . '%';
      $query = product_information::with('ProductPrice')->whereLike([
         "parentID",
         "product_name",
         "sku_code",
         "brand",
         "supplierID",
         "track_inventory",
         "same_price",
         "short_description",
         "notification_email",
      ], $searchTerm)->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc');

      if (Auth::user()->account_type === 'Admin') {
         $products = $query->paginate($this->perPage);
      } else {
         $products = $query->where('distributor_id', Auth::user()->id)->paginate($this->perPage);
      }

      return view('livewire.products.products', compact('products'));
   }

   public function deactivate($id)
   {
      product_information::whereId($id)->update(
         ['status' => 0]
      );
      session()->flash('success', 'Product disabled successfully.');
      return redirect()->to('/products');
   }

   public function activate($id)
   {
      product_information::whereId($id)->update(
         ['status' => 1]
      );
      session()->flash('success', 'Product activated successfully.');
      return redirect()->to('/products');
   }


  

}
