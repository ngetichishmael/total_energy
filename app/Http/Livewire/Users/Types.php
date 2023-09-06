<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Types extends Component
{
    public $perPage = 10;
    public $search = '';

    public function render()
    {
        $user = Auth::user();
        $userRole = $user->account_type;
        $userRouteCode = $user->route_code;

        $listsQuery = User::query();
        $countsQuery = User::query();

        if ($userRole !== 'Admin') {
            $listsQuery->where(function ($query) use ($userRouteCode) {
                $query->where('route_code', $userRouteCode)
                    ->orWhereNull('route_code');
            });

            $countsQuery->where(function ($query) use ($userRouteCode) {
                $query->where('route_code', $userRouteCode)
                    ->orWhereNull('route_code');
            });
        }

        $lists = $listsQuery->pluck('account_type')->unique();

        $counts = $countsQuery->groupBy('account_type')
            ->selectRaw('account_type, count(id) as count')
            ->pluck('count', 'account_type');

        $users = User::with('region') // Assuming 'region' is a related model
            ->paginate($this->perPage);

        return view('livewire.users.user-types', compact('lists', 'counts', 'users'));
    }

    public function deactivate($id)
    {
        User::whereId($id)->update(
            ['status' => "Suspended"]
        );
        session()->flash('success', 'Admin Disabled Successfully');
        //   return redirect()->to('/users/admins');
    }
    public function activate($id)
    {
        User::whereId($id)->update(
            ['status' => "Active"]
        );
        session()->flash('success', 'Admin Activated Successfully');
        //   return redirect()->to('/users/admins');
    }
    // Other methods for activation and deactivation can be added here
}
