<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Area;
use App\Models\customers;
use App\Models\Subregion;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;

class Customer extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $start;
    public $end;
    use WithPagination;
    public $perPage = 15;
    public $search = '';
    public $orderBy = 'order_count'; // Change the default ordering column
    public $orderAsc = false;
    public $customer_name = null;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        // Get initial query
        $contactsQuery = Customers::query();
    
        // Apply search filter if the search input is not empty
        if (!empty($this->search)) {
            $contactsQuery->where('customer_name', 'LIKE', '%' . $this->search . '%')
                          ->orWhere('email', 'LIKE', '%' . $this->search . '%');
        }
    
        // Join orders table and calculate order counts
        $contactsQuery->leftJoin('orders', 'customers.id', '=', 'orders.customerID')
                      ->selectRaw('customers.*, COUNT(orders.id) as order_count, MAX(orders.delivery_date) as last_order_date')
                      ->groupBy('customers.id', 'customers.soko_uuid', 'customers.external_uuid', 'customers.source', 'customers.customer_name', 'customers.account', 'customers.manufacturer_number', 'customers.vat_number', 'customers.approval', 'customers.delivery_time', 'customers.address', 'customers.city', 'customers.province', 'customers.postal_code', 'customers.country', 'customers.latitude', 'customers.longitude', 'customers.contact_person', 'customers.telephone', 'customers.customer_group', 'customers.customer_secondary_group', 'customers.price_group', 'customers.route', 'customers.route_code', 'customers.region_id', 'customers.subregion_id', 'customers.zone_id', 'customers.unit_id', 'customers.branch', 'customers.status', 'customers.email', 'customers.image', 'customers.phone_number', 'customers.business_code', 'customers.created_by', 'customers.updated_by', 'customers.created_at', 'customers.updated_at')
                      ->orderBy('order_count', $this->orderAsc ? 'asc' : 'desc');
    
        // Get paginated results
        $contacts = $contactsQuery->paginate($this->perPage);
        
        $count = ($this->perPage * ($contacts->currentPage() - 1)) + 1;
    
        // Return the rendered view with data
        return view('livewire.reports.customer', compact('contacts', 'count'));
    }
    
    
    public function export()
    {
        return Excel::download(new CustomersExport, 'Customers.xlsx');
    }
}
