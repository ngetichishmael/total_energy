<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Admins extends Component
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
        $admins = User::where('account_type', ['Admin'])->whereLike([
            'Region.name', 'name', 'email', 'phone_number',
        ], $searchTerm)
            ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
            ->paginate($this->perPage);

        return view('livewire.users.admins', compact('admins'));
    }
    public function deactivate($id)
    {
        User::whereId($id)->update(
            ['status' => "Suspended"]
        );
        session()->flash('success', 'Admin Disabled Successfully');
        return redirect()->to('/users/admins');
    }
    public function activate($id)
    {
        User::whereId($id)->update(
            ['status' => "Active"]
        );
        session()->flash('success', 'Admin Activated Successfully');
        return redirect()->to('/users/admins');
    }

    public function destroy($id)
    {
        if ($id) {
            $user = User::where('id', $id);
            $user->delete();
            session()->flash('success', 'Admin Deleted Successfully');
            return redirect()->to('/users/admins');
        }
    }
}
