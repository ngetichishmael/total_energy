<?php

namespace App\Http\Livewire\Warehousing;

use App\Models\Region;
use Livewire\Component;
use App\Models\warehousing;
use Livewire\WithPagination;
use Auth;
class Index extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public $orderBy = 'id';
   public $orderAsc = true;
   public ?string $search = null;
   public $user;


//   public function updatingSearch()
//   {
//      $this->resetPage();
//   }

//   public function render()
//   {
//      $warehouses = warehousing::where('business_code', Auth::user()->business_code)
//                              ->orderBy($this->orderBy,$this->orderAsc ? 'asc' : 'desc')
//                              ->simplePaginate($this->perPage);
//
//      return view('livewire.warehousing.index', compact('warehouses'));
//   }
   public function __construct()
   {
      $this->user = \Illuminate\Support\Facades\Auth::user();
   }
   public function render()
   {
      $searchTerm = '%' . $this->search . '%';
      $warehouses = warehousing::with( 'region', 'subregion')->withCount('productInformation')
         ->when($this->user->account_type === "Managers", function($query){
            $query->whereIn('region_id', $this->filter());
         })
         ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);


      return view('livewire.warehousing.index', [
         'warehouses' => $warehouses,
         'searchTerm' => $searchTerm
      ]);
   }
   public function filter(): array
   {

      $array = [];
      $user = Auth::user();
      $user_code = $user->region_id;
      if (!$user->account_type === 'RSM') {
         return $array;
      }
      $regions = Region::where('id', $user_code)->pluck('id');
      if ($regions->isEmpty()) {
         return $array;
      }
      return $regions->toArray();
   }
}


