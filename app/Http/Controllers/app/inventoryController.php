<?php

namespace App\Http\Controllers\app;

use App\Models\RequisitionProduct;
use App\Models\StockRequisition;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\inventory\allocations;

class inventoryController extends Controller
{
   //allocated
   public function allocated(){
      return view('app.inventory.allocated');
   }

   //allocate user
   public function allocate_user(Request $request){
      $code = Str::random(20);
      $item = new allocations;
      $item->business_code = Auth::user()->business_code;
      $item->allocation_code = $code;
      $item->sales_person = $request->sales_person;
      $item->date_allocated = date("Y-m-d");
      $item->status = 'Waiting acceptance';
      $item->created_by = Auth::user()->user_code;
      $item->save();

      Session()->flash('success','Allocate products to sales person');

      return redirect()->route('inventory.allocate.items',$code);
   }

   //allocate items
   public function allocate_items($code){
      return view('app.inventory.allocate_items', compact('code'));
   }
   public function approval()
   {
      return view('app.inventory.approving');
   }

   public function approve($id){
      return view('app.inventory.approve_items', compact('id'));
   }

   public function handleApproval(Request $request)
   {
      $selectedProducts = $request->input('selected_products', []);
      $user = $request->user();
      $user_code = $user->user_code;
      $business_code = $user->business_code;
      $random = Str::random(20);
      if (empty($selectedProducts)) {
         session()->flash('Error','Not products selected');
         return redirect('warehousing/all/stock-requisition');
      }else{
         foreach ($selectedProducts as $productId) {
            $product = RequisitionProduct::find($productId);

            if ($product) {
               if ($request->has('approve')) {
                  $product->update(['approval' => 1]);
                  StockRequisition::where('id',$request->requisition_id)->update([
                     'status'=>'Approved'
                  ]);
//               $image_path = 'image/92Ct1R2936EUcEZ1hxLTFTUldcSetMph6OGsWu50.png';
//               $value = [
//                  'productID' => $product->id,
//                  'qty' => $product->quantity,
//               ];
//
//               $stocked = product_inventory::find($product->id);
//               StockLiftHelper::updateOrCreateItems(
//                  $user_code,
//                  $business_code,
//                  $value,
//                  $image_path,
//                  $random,
//                  $stocked
//               );
               } elseif ($request->has('disapprove')) {
                  $product->update(['approval' => 0]);
                  StockRequisition::where('id',$request->requisition_id)->update([
                     'status'=>'Approved'
                  ]);
//               items::where('product_code', $product->productID)
//                  ->decrement('allocated_qty', $product->quantity);
//
//               product_inventory::where('productID', $product->productID)
//                  ->increment('current_stock', $product->quantity);
                  //product_inventory::whereId($productId)->increment('current_stock', $product->quantity);
               }
            }
         }
      }
      session()->flash('success','Allocated products to sales person');
      return redirect('warehousing/all/stock-requisition');
   }
}
