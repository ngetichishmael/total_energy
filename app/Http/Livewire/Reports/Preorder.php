<?php

namespace App\Http\Livewire\Reports;

use App\Models\Area;
use App\Models\customer\customers;
use App\Models\Orders;
use App\Models\Subregion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Preorder extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $start;
    public $end;
    public $search = null;

    public $perPage; // Define the perPage property

    public function __construct($perPage)
    {
        $this->perPage = $perPage;
    }
    public function render()
    {
        $count = 1;

<<<<<<< HEAD
      return view('livewire.reports.preorder', [
         'preorders' => $this->data(),
         'count' => $count
      ]);
   }
   public function data()
   {
       $query = Orders::with('User', 'Customer')->where('order_type', 'Pre Order');
       
       if (!is_null($this->start)) {
           if (Carbon::parse($this->start)->equalTo(Carbon::parse($this->end))) {
               $query->whereDate('created_at', 'LIKE', "%" . $this->start . "%");
           } else {
               if (is_null($this->end)) {
                   $this->end = Carbon::now()->endOfMonth()->format('Y-m-d');
               }
               $query->whereBetween('created_at', [$this->start, $this->end]);
           }
       }
       
       // Add sorting by created_at in descending order
       $query->orderBy('created_at', 'desc');
   
       return $query->paginate(15);
   }
   
   public function filter(): array
   {
=======
        return view('livewire.reports.preorder', [
            'preorders' => $this->data(),
            'count' => $count,
        ]);
    }
    public function data()
    {
        $query = Orders::with('User', 'Customer')->where('order_type', 'Pre Order');
        if (!is_null($this->start)) {
            if (Carbon::parse($this->start)->equalTo(Carbon::parse($this->end))) {
                $query->whereDate('created_at', 'LIKE', "%" . $this->start . "%");
            } else {
                if (is_null($this->end)) {
                    $this->end = Carbon::now()->endOfMonth()->format('Y-m-d');
                }
                $query->whereBetween('created_at', [$this->start, $this->end]);
            }
        }

        return $query->orderBy('id', 'DESC')->paginate(15);
    }
    public function filter(): array
    {
>>>>>>> origin/ish

        $array = [];
        $user = Auth::user();
        $user_code = $user->route_code;
        if (!$user->account_type === 'Managers') {
            return $array;
        }
        $subregions = Subregion::where('region_id', $user_code)->pluck('id');
        if ($subregions->isEmpty()) {
            return $array;
        }
        $areas = Area::whereIn('subregion_id', $subregions)->pluck('id');
        if ($areas->isEmpty()) {
            return $array;
        }
        $customers = customers::whereIn('route_code', $areas)->pluck('id');
        if ($customers->isEmpty()) {
            return $array;
        }
        return $customers->toArray();
    }
    // public function export()
    // {
    //    return Excel::download(new PreorderExport, 'preorders.xlsx');
    // }
}
