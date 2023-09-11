<?php

namespace App\Http\Livewire\Reports;

use App\Exports\CustomersExport;
use App\Models\customers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
     
        //$count = ($this->perPage * ($contacts->currentPage() - 1)) + 1;
        return view('livewire.reports.customer', ['contacts' => $this->data()]);
    }
    public function data()
    {
        $searchTerm = '%' . $this->search . '%';
        $contactsQuery = Customers::withCount('Orders')
        ->whereHas('Orders')
        ->leftJoin('orders', 'customers.id', '=', 'orders.customerID')
        ->selectRaw(
            'customers.customer_name as customer_number,
            customers.phone_number as phonenumber,
            COUNT(orders.id) as order_count,
            MAX(orders.delivery_date) as last_ordering_date'
        )
        ->groupBy(
            'customers.id',
            'customers.soko_uuid',
            'customers.external_uuid',
            'customers.source',
            'customers.customer_name',
            'customers.account',
            'customers.manufacturer_number',
            'customers.vat_number',
            'customers.approval',
            'customers.delivery_time'
        )
        ->orderBy('order_count', $this->orderAsc ? 'asc' : 'desc');
    $contacts = $contactsQuery->paginate($this->perPage);
    if (strcasecmp(Auth::user()->account_type, 'distributor') == 0) {
        foreach ($contacts as $contact) {
            if ($contact->Area && $contact->Area->Subregion && $contact->Area->Subregion->Region) {
                $contact->Area->Subregion->Region->id;
            }
            if ($contact->Area->Subregion->id) {
                $contact->Area->Subregion->id;
            }
        }
    }
      return  $contactsQuery->paginate($this->perPage);
    }

    public function export()
    {
        return Excel::download(new CustomersExport(), 'Customers.xlsx');
    }
    public function exportCSV()
    {
        return Excel::download(new CustomersExport(), 'Customers.csv');
    }

    public function exportPDF()
    {
        $data = [
            'contacts' => $this->data(),
        ];

        $pdf = Pdf::loadView('Exports.customer_pdf', $data);

        // Add the following response headers
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Customers.pdf');
    }
}
