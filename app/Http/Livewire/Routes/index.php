<?php

namespace App\Http\Livewire\Routes;

use App\Models\Routes;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 15;
    public $search = null;

    public function render()
    {
        // Check if the authenticated user has an 'admin' account_type
        if (auth()->user()->account_type == 'Admin') {
            $searchTerm = '%' . $this->search . '%';
            $routes = Routes::with(['User:id,name', 'Customers.customer'])
                ->whereLike(['name' ], $searchTerm)
                ->whereHas('Customers')
                ->whereHas('User')
                ->withCount('Customers')
                ->paginate($this->perPage);
        } else {
            // Get the authenticated user's route_code
            $userRouteCode = Auth::user()->route_code;
            $searchTerm = '%' . $this->search . '%';

            // Find routes where the associated user has a route_code matching $userRouteCode
            $routes = Routes::with('user')
                ->whereHas('user', function ($query) use ($userRouteCode) {
                    $query->where('route_code', $userRouteCode);
                })
                ->whereLike(['name' ], $searchTerm)
                ->whereHas('user', function ($query) use ($userRouteCode) {
                    $query->where('id', '!=', Auth::id()); // Exclude the authenticated user's routes
                })
                ->paginate($this->perPage);
        }

        return view('livewire.routes.index', compact('routes'));
    }
}
