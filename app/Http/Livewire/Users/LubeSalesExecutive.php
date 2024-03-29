<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Region;
use App\Models\Subregion;
use App\Models\User;
use App\Models\zone;
use Livewire\WithPagination;

class LubeSalesExecutive extends Component
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
            $LubeSalesExecutive = $query->where('account_type', 'Lube Sales Executive')->paginate($this->perPage);
         } else {
            $LubeSalesExecutive = $query->where('account_type', 'Lube Sales Executive')
                  ->where('route_code', $user->route_code)
                  ->paginate($this->perPage);
         }

         return view('livewire.users.lube-sales-executive', compact('LubeSalesExecutive'));
      }


    public function deactivate($id)
    {
       User::whereId($id)->update(
          ['status' => "Suspended"]
       );
       session()->flash('success', 'User Disabled Successfully');
       return redirect()->to('/users/LubeSalesExecutive');
    }
    public function activate($id)
    {
       User::whereId($id)->update(
          ['status' => "Active"]
       );
       session()->flash('success', 'User Activated Successfully');
       return redirect()->to('/users/LubeSalesExecutive');
    }

    public function destroy($id)
    {
        if ($id) {
            $user = User::where('id', $id);
            $user ->delete();
            session()->flash('success', 'User Deleted Successfully');
            return redirect()->to('/users/LubeSalesExecutive');
        }
    }

}
