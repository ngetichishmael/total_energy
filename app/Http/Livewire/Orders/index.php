<?php

namespace App\Http\Livewire\Orders;

use App\Exports\OrdersExport;
use Livewire\Component;
use App\Models\Orders;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 5;
   public ?string $search = null;
   public $orderBy = 'orders.id';
   public $orderAsc = false;
   public $customer_name = null;


   public function render()
   {


      return view('livewire.orders.index', [
         'orders' => $this->orders()
      ]);
   }
   public function orders()
   {

      $searchTerm = '%' . $this->search . '%';
      $perpage = $this->search == null ? $this->perPage : 1000;
      $orders =  Orders::with('Customer', 'user', 'OrderItems')
         ->search($searchTerm)
         ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
         ->paginate($perpage);
      return $orders;
   }
   public function shipment()
   {

      return redirect()->route('picking-sheet')->with([
         "products" => $this->orders(),
      ]);
   }
   public function export()
   {
      return Excel::download(new OrdersExport, 'orders.xlsx');
   }

   public function deactivate($id)
   {

      Orders::whereId($id)->update([
         'order_status' => 'CANCELLED',
      ]);
      $this->render();
   }
   public function activate($id)
   {
      Orders::whereId($id)->update([
         'order_status' => 'Pending Delivery',
      ]);
      $this->render();
   }
}
