<?php

namespace App\Http\Livewire\Customers;

use App\Exports\Customers as ExportsCustomers;
use App\Models\AssignedRegion;
use App\Models\customers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = null;
    public $start = null;
    public $end = null;
    public $user;
    public $regionFilter = null;
    public $statusFilter = null;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        $regions = AssignedRegion::where('user_code', $this->user->user_code)->get();
        $contacts = $this->getCustomer();

        return view('livewire.customers.dashboard', compact('contacts', 'regions'));
    }

    public function export()
    {
        return Excel::download(new ExportsCustomers, 'customers.xlsx');
    }

    public function deactivate($id)
    {
        Customers::whereId($id)->update([
            'approval' => "Suspended"
        ]);
        return redirect()->to('/customer');
    }

    public function activate($id)
    {
        Customers::whereId($id)->update([
            'approval' => "Approved"
        ]);

        return redirect()->to('/customer');
    }

    public function areas()
    {
        $user_code = $this->user->user_code;
        $regions = AssignedRegion::where('user_code', $user_code)->pluck('region_id');
        return $regions->toArray();
    }

    public function getCustomer()
    {
        $searchTerm = '%' . $this->search . '%';
        $query = Customers::search($searchTerm)->orderBy('id', 'DESC');

        if (Auth::user()->account_type !== 'Admin') {
            $query->whereIn('region_id', $this->areas());
        }

        if (!is_null($this->regionFilter)) {
            $query->where('region_id', $this->regionFilter);
        }

        if (!is_null($this->statusFilter)) {
            $query->where('approval', $this->statusFilter);
        }

        if (is_null($this->start) && is_null($this->end)) {
            $contacts = $query->paginate($this->perPage);
            return $contacts;
        }

        if (!is_null($this->start)) {
            $end = Carbon::now()->endOfMonth()->format('Y-m-d');
            $query->whereBetween('created_at', [$this->start, $end]);
        }

        if (!is_null($this->start) && Carbon::parse($this->start)->isSameDay(Carbon::parse($this->end))) {
            $query->where('created_at', 'LIKE', '%' . $this->start . '%');
        }

        $contacts = $query->paginate($this->perPage);
        return $contacts;
    }

    public function updatedStart()
    {
        $this->mount();
        $this->render();
    }

    public function updatedEnd()
    {
        $this->mount();
        $this->render();
    }
}
