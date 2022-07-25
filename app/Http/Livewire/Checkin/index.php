<?php

namespace App\Http\Livewire\Checkin;

use Livewire\Component;
use App\Models\customer\checkin;
use Livewire\WithPagination;
use Auth;
class Index extends Component
{
   use WithPagination;
   public $perPage = 40;
   public $search = '';
   public $orderBy = 'customer_checkin.id';
   public $orderAsc = false;

   public function updatingSearch()
   {
      $this->resetPage();
   }

   public function render()
   {
      $checkins =  checkin::join('customers','customers.id','=','customer_checkin.customer_id')
                           ->join('users','users.user_code','=','customer_checkin.user_code')
                           ->orderBy($this->orderBy,$this->orderAsc ? 'asc' : 'desc')
                           ->simplePaginate($this->perPage);

      return view('livewire.checkin.index', compact('checkins'));
   }
}


