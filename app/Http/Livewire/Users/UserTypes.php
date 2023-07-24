<?php

namespace App\Http\Livewire\Users;

use App\Models\Region;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserTypes extends Component
{
    public function render()
    {

        $accountTypes = Role::pluck('name')->toArray();

        $lists = Role::pluck('name');
        $counts = Role::leftJoin('users', 'roles.name', '=', 'users.account_type')
            ->whereIn('roles.name', $accountTypes)
            ->whereNotIn('roles.name', ['Customer'])
            ->groupBy('roles.name')
            ->selectRaw('roles.name, count(users.id) as count')
            ->pluck('count', 'roles.name');

        $count = 1;

        return view('livewire.users.user-types', [
            'lists' => $lists,
            'counts' => $counts,
            'count' => $count,
            'regions' => $this->regionalFilter(),
        ]);

    }

    public function regionalFilter()
    {
        $regionsData = Region::select('regions.name as region_name',
            'regions.id as region_id',
            DB::raw('COUNT(assigned_regions.user_code) as unique_users_count'))
            ->leftJoin('assigned_regions', 'regions.id', '=', 'assigned_regions.region_id')
            ->groupBy('regions.name')
            ->get();
        return $regionsData;
    }
}
