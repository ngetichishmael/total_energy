<?php

namespace App\Http\Livewire\Reports;

use App\Models\Area;
use App\Models\Subregion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;

class Customers extends Component
{
    protected $paginationTheme = 'bootstrap';
   public $start;
   public $end;
   use WithPagination;
   public $user;
   public $orderBy = 'customer.id';
   public $orderAsc = true;
   public function __construct()
   {
      $this->user = Auth::user();
   }
    public function render()
    {
        return view('livewire.reports.customers', ['customers'=>$this->data()]);
    }
   public function data()
   {
      $query = customers::has('orders')->withCount('orders');
      $query->whereIn('id', $this->filter())->get();
      return $query->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
         ->paginate(25);
   }
   public function filter(): array
   {

      $array = [];
//      $user = $this->user;
      $user_code = $this->user->user_code;
      $dataAccessLevel = $this->user->account_type;
      $subregions = Subregion::where('region_id', $this->user->region_id)->pluck('id');
      $areas = Area::whereIn('subregion_id', $subregions)->pluck('id');
      if (auth()->check() && $dataAccessLevel == 'Managers') {
         $customers = \App\Models\customer\customers::whereIn('route', $areas)->pluck('id');
         if ($customers->isEmpty()) {
            return $array;
         }
         return $customers->toArray();
      } elseif (auth()->check() && $dataAccessLevel == 'Admin') {
         $customers = customers::all()->pluck('id');
         if ($customers->isEmpty()) {
            return $array;
         }
         return $customers->toArray();
      }
      else{
         $customers = customers::where('region_id', $this->user->region_id)->pluck('id');
         if ($customers->isEmpty()) {
            return $array;
         }
         return $customers->toArray();
      }
//      if (!$user->account_type === 'RSM') {
//         return $array;
//      }
   }
    public function export()
   {
      return Excel::download(new CustomersExport, 'Customers.xlsx');
   }
}
