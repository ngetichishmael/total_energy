<?php

namespace App\Http\Livewire\Customers;

use App\Exports\customers as ExportsCustomers;
use App\Models\Area;
use App\Models\customers;
use App\Models\Subregion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public ?string $search = null;
   public function render()
   {

      return view('livewire.customers.dashboard', [
         'contacts' => $this->getCustomer()
      ]);
   }
   public function export()
   {
      return Excel::download(new ExportsCustomers, 'customers.xlsx');
   }
   public function deactivate($id)
   {
      customers::whereId($id)->update(
         ['approval' => "Suspended"]
      );
      return redirect()->to('/customer');
   }
   public function activate($id)
   {
      customers::whereId($id)->update(
         ['approval' => "Approved"]
      );

      return redirect()->to('/customer');
   }
   public function areas()
   {
      $user = Auth::user();
      $subregions = Subregion::where('region_id', $user->route_code)->pluck('id');
      $areas = Area::whereIn('subregion_id', $subregions)->pluck('id');
      return $areas;
   }
   public function getCustomer()
   {
      $searchTerm = '%' . $this->search . '%';
      $query = customers::search($searchTerm)
         ->orderBy('id', 'DESC');

      if (Auth::user()->account_type != 'Admin') {
         $query->whereIn('unit_id', $this->areas());
      }

      $contacts = $query->paginate($this->perPage);
      return $contacts;
   }
}
