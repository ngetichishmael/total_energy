<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class UserTypes extends Component
{
    public function render()
    {
        $user = Auth::user(); // Get the logged-in user

        $userRole = $user->account_type; // Get the logged-in user's role

        $accountTypes = Role::pluck('name')->toArray();

        $listsQuery = User::query();

        // If the user's role is not "Admin", exclude the "Admin" role from the query
        if ($userRole !== 'Admin') {
            $listsQuery->where('account_type', '!=', 'Admin');
        }

        // If the user's role is not "Admin", include route_code related to the logged-in user
        if ($userRole !== 'Admin') {
            $listsQuery->where(function ($query) use ($user) {
                $query->where('route_code', $user->route_code)
                    ->orWhereNull('route_code');
            });
        }

        $lists = $listsQuery->pluck('account_type')->unique();

        $countsQuery = Role::leftJoin('users', 'roles.name', '=', 'users.account_type')
            ->whereIn('roles.name', $accountTypes)
            ->whereNotIn('roles.name', ['Customer']);

        // If the user's role is not "Admin", exclude the "Admin" role from the counts query
        if ($userRole !== 'Admin') {
            $countsQuery->where('roles.name', '!=', 'Admin');
        }

        // If the user's role is not "Admin", include route_code related to the logged-in user
        if ($userRole !== 'Admin') {
            $countsQuery->where(function ($query) use ($user) {
                $query->where('users.route_code', $user->route_code)
                    ->orWhereNull('users.route_code');
            });
        }

        $counts = $countsQuery->groupBy('roles.name')
            ->selectRaw('roles.name, count(users.id) as count')
            ->pluck('count', 'roles.name');

        $count = 1;

        return view('livewire.users.user-types', compact('lists', 'counts', 'count'));
    }
}
