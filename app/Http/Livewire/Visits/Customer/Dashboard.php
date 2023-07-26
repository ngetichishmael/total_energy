<?php

namespace App\Http\Livewire\Visits\Customer;

use App\Models\AssignedRegion;
use App\Models\customer\checkin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = null;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }
    public function render()
    {
        return view('livewire.visits.customer.dashboard', [
            'visits' => $this->data(),
        ]);
    }
    public function data()
    {
        $searchTerm = '%' . $this->search . '%';

        $visits = checkin::join('users', 'users.user_code', '=', 'customer_checkin.user_code')
            ->join('customers', 'customers.id', '=', 'customer_checkin.customer_id')
            ->join('regions', 'customers.region_id', '=', 'regions.id')
            ->whereColumn('customer_checkin.start_time', '<=', 'customer_checkin.stop_time')
            ->where(function ($query) use ($searchTerm) {
                $query->where('users.name', 'like', $searchTerm)
                    ->orWhere('customers.customer_name', 'like', $searchTerm)
                    ->orWhere('regions.name', 'like', $searchTerm);
            });

        if ($this->user->account_type !== 'Admin') {
            $visits->whereIn('customers.region_id', $this->getUserBasedonRegions());
        }

        $visits = $visits->select(
            'users.name as sales_agent',
            'regions.name as region_name',
            'customers.customer_name as customer_name',
            'customer_checkin.start_time as start_time',
            'customer_checkin.stop_time as stop_time',
            DB::raw('TIMEDIFF(customer_checkin.stop_time, customer_checkin.start_time) as duration')
        )
            ->paginate($this->perPage);

        return $visits;
    }

    public function getUserBasedonRegions()
    {
        return AssignedRegion::where('user_code', $this->user->user_code)
            ->pluck('region_id')
            ->toArray();
    }
}
