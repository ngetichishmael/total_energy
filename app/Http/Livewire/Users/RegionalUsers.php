<?php

namespace App\Http\Livewire\Users;

use App\Models\AssignedRegion;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class RegionalUsers extends Component
{
    use WithPagination;

    public $region_id;
    public $region_name;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {

        return view('livewire.users.regional-users', [
            'users' => $this->regionalFilter(),
            'region_name' => $this->region_name,
        ]);
    }

    public function regionalFilter()
    {

        $assigned_regions = AssignedRegion::where('region_id', $this->region_id)->pluck('user_code');
        $regionsData = User::whereIn('user_code', $assigned_regions)->paginate(20);
        return $regionsData;
    }
}
