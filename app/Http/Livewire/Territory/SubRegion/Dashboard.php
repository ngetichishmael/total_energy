<?php

namespace App\Http\Livewire\Territory\SubRegion;

use App\Models\AssignedRegion;
use App\Models\Subregion;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 20;
    public $sortField = 'id';
    public $sortAsc = true;
    public $user;
    public $search = ''; // Search input

    public function mount()
    {
        $this->user = Auth::user();
    }
    public function render()
    {
        $query = Subregion::query();

        if ($this->user && $this->user->account_type !== 'Admin') {
            $query->whereIn('region_id', $this->region());
        }

        $regions = Region::all();

        $subregions = $query
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.territory.sub-region.dashboard', [
            'subregions' => $subregions,
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
