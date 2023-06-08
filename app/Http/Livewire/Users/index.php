<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public $orderBy = 'id';
   public $orderAsc = true;
   public ?string $search = null;

   public function render()
   {
      return view('livewire.users.index',[
            'users' => $this->getUsers()
         ]
      );
   }
   public function getUsers()
   {
      $searchTerm = '%' . $this->search . '%';
      $query = User::search($searchTerm)
         ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc');
      $user = Auth::user();
      if ($user->account_type != 'Admin') {
         $query->where('route_code', $user->route_code);
      }

      return $query->paginate($this->perPage);
   }
   public function deactivate($id)
   {
      User::whereId($id)->update(
         ['status' => "Suspended"]
      );
      return redirect()->to('/users');
   }
   public function activate($id)
   {
      User::whereId($id)->update(
         ['status' => "Active"]
      );

      return redirect()->to('/users');
   }
}
