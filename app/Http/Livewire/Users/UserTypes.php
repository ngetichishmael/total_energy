<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;

use App\Models\User;
use App\Models\Role;

class UserTypes extends Component
{
    public function render()
    {
        $accountTypes = Role::pluck('name')->toArray();

        $lists = User::whereIn('account_type', $accountTypes)
            ->distinct('account_type')
            ->whereNotIn('account_type', ['Customer'])
            ->groupBy('account_type')
            ->pluck('account_type');

        $counts = User::join('roles', 'users.account_type', '=', 'roles.name')
            ->whereIn('users.account_type', $accountTypes)
            ->whereNotIn('users.account_type', ['Customer'])
            ->groupBy('users.account_type')
            ->selectRaw('users.account_type, count(*) as count')
            ->pluck('count', 'users.account_type');

        $count = 1;

        return view('livewire.users.user-types', compact('lists', 'counts', 'count'));
     
    }
}
