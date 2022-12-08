<?php

namespace App\Http\Livewire\Users;
use App\Models\User;
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
                     ->orderBy($this->orderBy,$this->orderAsc ? 'desc' : 'asc')
                     ->paginate($this->perPage);

      return view('livewire.users.index', compact('users'));
   }
}
