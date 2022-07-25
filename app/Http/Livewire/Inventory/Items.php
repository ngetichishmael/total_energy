<?php

namespace App\Http\Livewire\Inventory;


use App\Models\inventory\items as InventoryItems;
use App\Models\products\product_information;

use Livewire\Component;
use Auth;

class Items extends Component
{
   public $code, $product, $quantity, $inventoryQuantity = 12;

   public function render()
   {
      $allocationCode = $this->code;
      $products = product_information::where('business_code',Auth::user()->business_code)->get();
      $allocatedItems = InventoryItems::join('product_information','product_information.id','=','inventory_allocated_items.product_code')
                                       ->where('inventory_allocated_items.business_code',Auth::user()->business_code)
                                       ->where('allocation_code',$allocationCode)
                                       ->orderby('inventory_allocated_items.id','desc')
                                       ->get();

      return view('livewire.inventory.items', compact('products','allocatedItems','allocationCode'));
   }

   //validation
   protected $rules = [
      'product' => 'required',
      'quantity' => 'required',
   ];

   //allocate
   public function allocate_item(){
      $allocate = new InventoryItems;
      $allocate->business_code = Auth::user()->business_code;
      $allocate->allocation_code = $this->code;
      $allocate->product_code = $this->product;
      $allocate->current_qty = $this->quantity;
      $allocate->allocated_qty = $this->quantity;
      $allocate->returned_qty = 0;
      $allocate->created_by = Auth::user()->user_code;
      $allocate->save();

      // Set Flash Message
      $this->dispatchBrowserEvent('alert',[
         'type'=>'success',
         'message'=>"Product Allocated"
      ]);

      $this->restFields();
   }

   //reset fiels
   public function restFields(){
      $this->product = "";
      $this->quantity = "";
   }

}
