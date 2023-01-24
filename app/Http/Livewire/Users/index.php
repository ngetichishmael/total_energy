<?php

namespace App\Http\Livewire\Users;

use App\Models\Region;
use App\Models\Subregion;
use App\Models\User;
use App\Models\zone;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Index extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public $search = '';
   public $orderBy = 'id';
   public $orderAsc = true;

   public function render()
   {

      $users =  User::where('business_code', FacadesAuth::user()->business_code)
         ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
         ->paginate($this->perPage);

      return view('livewire.users.index', compact('users'));
   }
   public function name($primarykey)
   {
      $name = null;
      if (Region::where('primary_key', $primarykey)->get()) {
         $name = Region::where('primary_key', $primarykey)->pluck('name')->implode('');
         dd($name);
      } else if (Subregion::where('primary_key', $primarykey)->get()) {
         $name = Subregion::where('primary_key', $primarykey)->pluck('name')->implode('');
      } else if (zone::where('primary_key', $primarykey)->get()) {
         $name = zone::where('primary_key', $primarykey)->pluck('name');
      }


      return $name;
   }
}