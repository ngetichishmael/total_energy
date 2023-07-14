<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Region;
use App\Models\Subregion;
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
 
    public function render()
    {
       $searchTerm = '%' . $this->search . '%';
       $sales =  User::where('account_type', ['Sales'])->whereLike([
          'Region.name', 'name', 'email', 'phone_number',
       ], $searchTerm)
          ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
          ->paginate($this->perPage);
 
       return view('livewire.users.sales', compact('sales'));
    }
    public function deactivate($id)
    {
       User::whereId($id)->update(
          ['status' => "Suspended"]
       );
       return redirect()->to('/users/merchandizer');
    }
    public function activate($id)
    {
       User::whereId($id)->update(
          ['status' => "Active"]
       );
 
       return redirect()->to('/users/merchandizer');
    }

    public function destroy($id)
    {
        if ($id) {
            $user = User::where('id', $id);
            $user ->delete();

            return redirect()->to('/users/merchandizer');
        }
    }

}
