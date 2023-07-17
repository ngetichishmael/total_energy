<?php

namespace App\Http\Livewire\Territory\Region;

use App\Models\AssignedRegion;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $perPage = 40;
    public $sortField = 'id';
    public $sortAsc = true;

    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render(): View
    {
        $query = Region::query();

        if ($this->user && $this->user->account_type !== 'Admin') {
            $query->whereIn('id', $this->region());
        }

        $regions = $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->paginate($this->perPage);

        return view('livewire.territory.region.dashboard', [
            'regions' => $regions,
        ]);
    }

    public function region(): array
    {
        $user_code = $this->user->user_code;

        $regions = AssignedRegion::where('user_code', $user_code)->pluck('region_id');
        return $regions->toArray();
    }
}
