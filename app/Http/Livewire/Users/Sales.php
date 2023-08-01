<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Region;
use App\Models\Subregion;
use App\Models\Area;
use App\Models\User;
use App\Models\zone;
use Livewire\WithPagination;

class Sales extends Component
{

   use WithPagination;

   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public $orderBy = 'id';
   public $orderAsc = true;
   public ?string $search = null;
   public $selectedSubregion = null;
   public $selectedArea = null;

   public function mount()
   {
       $this->subregions = Subregion::all();
   }

   public function render()
   {
       $searchTerm = '%' . $this->search . '%';
       $query = User::query()
           ->where('account_type', 'Sales');

       if ($this->selectedSubregion) {
           $query->whereHas('area.subregion', function ($query) {
               $query->where('id', $this->selectedSubregion);
           });
       }

       if ($this->selectedArea) {
           $query->where('area_id', $this->selectedArea);
       }

       $sales = $query
           ->whereLike([
               'Region.name', 'name', 'email', 'phone_number',
           ], $searchTerm)
           ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
           ->paginate($this->perPage);

       return view('livewire.users.sales', [
           'sales' => $sales,
           'areas' => $this->areas,
       ]);
   }

   public function getAreasProperty()
   {
       if ($this->selectedSubregion) {
           return Subregion::findOrFail($this->selectedSubregion)->areas;
       }

       return collect([]);
   }

   public function deactivate($id)
   {
       User::whereId($id)->update(['status' => "Suspended"]);
       return redirect()->to('/users/sales');
   }

   public function activate($id)
   {
       User::whereId($id)->update(['status' => "Active"]);
       return redirect()->to('/users/sales');
   }

   public function destroy($id)
   {
       if ($id) {
           $user = User::where('id', $id);
           $user->delete();

           return redirect()->to('/users/sales');
       }
   }

}