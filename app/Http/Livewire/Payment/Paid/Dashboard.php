<?php

namespace App\Http\Livewire\Payment\Paid;

use App\Models\Delivery;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{

   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 5;
   public $search = '';
   public $orderBy = 'delivery.id';
   public $orderAsc = true;
   public $customer_name = null;
   public $name = null;
   public $order_code = null;
   public function render()
   {
      $deliveries = Delivery::with(['Customer', 'Order', 'User'])
         ->where('delivery_status', 'DELIVERED')
         ->orderBy('id', 'desc')
         ->paginate($this->perPage);
      return view('livewire.payment.paid.dashboard', [
         'deliveries' => $deliveries
      ]);
   }
   public function approve($id)
   {
      Delivery::whereId($id)->update([
         'approval' => 1
      ]);
      $this->render();
   }
}
