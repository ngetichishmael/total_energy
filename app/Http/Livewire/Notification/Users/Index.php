<?php

namespace App\Http\Livewire\Notification\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public ?string $search = null;
   public $perPage = 10;
   public $sortField = 'id';
   public $sortAsc = true;
   public bool $bulkDisabled = true;
   public $selectedData = [];
   public function render()
   {

      $this->bulkDisabled = count($this->selectedData) < 1;

      $searchTerm = '%' . $this->search . '%';
      $users = User::where('account_type', "Sales")->whereLike(
         [
            'name',
            'phone_number',
         ],
         $searchTerm
      )
         ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);
      return view('livewire.notification.users.index', [
         "users" => $users
      ]);
   }
}
