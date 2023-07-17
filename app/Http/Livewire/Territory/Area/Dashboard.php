<?php

namespace App\Http\Livewire\Territory\Area;

use App\Models\Area;
use App\Models\AssignedRegion;
use App\Models\Subregion;
use Illuminate\Support\Facades\Auth;
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
    public function render()
    {
        $query = Area::query();

        if ($this->user && $this->user->account_type !== 'Admin') {
            $query->whereIn('subregion_id', $this->region());
        }

        $areas = $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->paginate($this->perPage);
        return view('livewire.territory.area.dashboard', [
            'areas' => $areas,
        ]);
    }
    public function region(): array
    {
        $array = [];
        $user_code = $this->user->user_code;

        $regions = AssignedRegion::where('user_code', $user_code)->pluck('region_id');
        if ($regions->isEmpty()) {
            return $array;
        }
        $subregions = Subregion::whereIn('region_id', $regions->toArray())->pluck('id');

        return $subregions->toArray();
    }
}
