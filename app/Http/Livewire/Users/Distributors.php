<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Region;
use App\Models\Subregion;
use App\Models\User;
use App\Models\zone;
use Livewire\WithPagination;

class Distributors extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $orderBy = 'id';
    public $orderAsc = true;
    public ?string $search = null;
 
    public function render()
    {
       $searchTerm = '%' . $this->search . '%';
       $distributors =  User::where('account_type', ['Distributors'])->whereLike([
          'Region.name', 'name', 'email', 'phone_number',
       ], $searchTerm)
          ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
          ->paginate($this->perPage);
 
       return view('livewire.users.distributors', compact('distributors'));
    }
    public function deactivate($id)
    {
       User::whereId($id)->update(
          ['status' => "Suspended"]
       );
       session()->flash('success', 'Distributor Disabled Successfully');
       return redirect()->to('/users/sales');
    }
    
    public function activate($id)
    {
       User::whereId($id)->update(
          ['status' => "Active"]
       );
       session()->flash('success', 'Distributor Activated Successfully');
       return redirect()->to('/users/sales');
    }

    public function destroy($id)
    {
        if ($id) {
            $user = User::where('id', $id);
            $user ->delete();
            session()->flash('success', 'Distributor Deleted Successfully');
            return redirect()->to('/users/sales');
        }
    }

}
