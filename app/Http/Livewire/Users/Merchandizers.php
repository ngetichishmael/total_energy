<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Region;
use App\Models\Subregion;
use App\Models\User;
use App\Models\zone;
use Livewire\WithPagination;

class Merchandizers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $orderBy = 'id';
    public $orderAsc = true;
    public ?string $search = null;
 

    public function render()
      {
         $user = auth()->user(); // Get the authenticated user

         $searchTerm = '%' . $this->search . '%';
         $query = User::whereLike([
            'Region.name', 'name', 'email', 'phone_number',
         ], $searchTerm)
         ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc');

         if ($user->account_type == 'Admin') {
            $merchandizer = $query->where('account_type', 'Lube Merchandizers')->paginate($this->perPage);
         } else {
            $merchandizer = $query->where('account_type', 'Lube Merchandizers')
                  ->where('route_code', $user->route_code)
                  ->paginate($this->perPage);
         }

         return view('livewire.users.merchandizers', compact('merchandizer'));
      }


    public function deactivate($id)
    {
       User::whereId($id)->update(
          ['status' => "Suspended"]
       );
       session()->flash('success', 'Merchandizer Disabled Successfully');
       return redirect()->to('/users/lubemerchandizer');
    }
    public function activate($id)
    {
       User::whereId($id)->update(
          ['status' => "Active"]
       );
       session()->flash('success', 'Merchandizer Activated Successfully');
       return redirect()->to('/users/lubemerchandizer');
    }

    public function destroy($id)
    {
        if ($id) {
            $user = User::where('id', $id);
            $user ->delete();
            session()->flash('success', 'Merchandizer Deleted Successfully');
            return redirect()->to('/users/lubemerchandizer');
        }
    }

}
