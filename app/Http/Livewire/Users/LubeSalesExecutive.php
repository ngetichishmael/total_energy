<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class LubeSalesExecutive extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $orderBy = 'id';
    public $orderAsc = true;
    public $search = null;

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $LubeSalesExecutive = User::where('account_type', ['Lube Sales Executive'])->whereLike([
            'Region.name', 'name', 'email', 'phone_number',
        ], $searchTerm)
            ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
            ->paginate($this->perPage);

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
            $user->delete();
            session()->flash('success', 'User Deleted Successfully');
            return redirect()->to('/users/LubeSalesExecutive');
        }
    }

}
