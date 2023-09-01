<?php

namespace App\Http\Livewire\Routes;

use App\Models\Routes;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public function render()
    {
        $routes = Routes::with(['User:id,name',
            'Customers.customer'])
            ->whereHas('Customers')
            ->whereHas('User')
            ->withCount('Customers')
            ->paginate($this->perPage);

        return view('livewire.routes.index', compact('routes'));
    }

}
