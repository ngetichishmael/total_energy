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
        $userRole = Auth::user()->account_type; // Get the logged-in user's role

        $accountTypes = Role::pluck('name')->toArray();

        $listsQuery = User::query();

        // If the user's role is not "Admin", exclude the "Admin" role from the query
        if ($userRole !== 'Admin') {
            $listsQuery->where('account_type', '!=', 'Admin');
        }

        $lists = $listsQuery->pluck('account_type')->unique(); // Renamed variable back to $lists

        $countsQuery = Role::leftJoin('users', 'roles.name', '=', 'users.account_type')
            ->whereIn('roles.name', $accountTypes)
            ->whereNotIn('roles.name', ['Customer']);

        // If the user's role is not "Admin", exclude the "Admin" role from the counts query
        if ($userRole !== 'Admin') {
            $countsQuery->where('roles.name', '!=', 'Admin');
        }

        $counts = $countsQuery->groupBy('roles.name')
            ->selectRaw('roles.name, count(users.id) as count')
            ->pluck('count', 'roles.name');

        $count = 1;

        return view('livewire.users.user-types', compact('lists', 'counts', 'count')); // Updated variable name here
    }
}
