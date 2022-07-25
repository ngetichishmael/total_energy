<?php

namespace App\Http\Livewire\Users;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Auth;


class Index extends Component
{
   use WithPagination;
   public $perPage = 10;
   public $search = '';
   public $orderBy = 'id';
   public $orderAsc = true;

   public function render()
   {

      $users =  User::where('business_code', Auth::user()->business_code)
                     ->orderBy($this->orderBy,$this->orderAsc ? 'desc' : 'asc')
                     ->simplePaginate($this->perPage);

      return view('livewire.users.index', compact('users'));
   }
}
