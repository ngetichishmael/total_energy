<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserTypes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $groupView = true; // Default to Group View
    public $perPage = 10;
    public $search = "";

    public function toggleView()
    {
        $this->groupView = !$this->groupView;
    }

    public function render()
    {
        $groups = $this->getUserGroups();
        $users = ($this->groupView) ? $this->getGroupUsers() : $this->getUsers();
        $counting = 1;
        return view('livewire.users.user-types', compact('groups', 'users', 'counting'));
    }

    private function buildBaseQuery()
    {
        $user = Auth::user();
        $userRole = $user->account_type;
        $userRouteCode = $user->route_code;

        $query = User::query();

        if ($userRole !== 'Admin') {
            $query->where(function ($query) use ($userRouteCode) {
                $query->where('route_code', $userRouteCode)
                    ->orWhereNull('route_code');
            });
        }

        return $query;
    }

    private function getUserGroups()
    {
        return $this->buildBaseQuery()
            ->groupBy('account_type')
            ->selectRaw('account_type, count(id) as count')
            ->pluck('count', 'account_type');
    }

    private function getGroupUsers()
    {
        return $this->getUserGroups()
            ->map(function ($count, $group) {
                return $this->buildBaseQuery()
                    ->where('account_type', $group)
                    ->get();
            })
            ->collapse();
    }

    public function getUsers()
    {
        $searchTerm = '%' . $this->search . '%';
        return $this->buildBaseQuery()
            ->search($searchTerm)
            ->paginate($this->perPage);
    }
}
