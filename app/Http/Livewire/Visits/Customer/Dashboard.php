<?php

namespace App\Http\Livewire\Visits\Customer;

use App\Exports\CustomerVisitExport;
use App\Models\customer\checkin;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Dashboard extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public ?string $search = null;
   public ?string $start = null; 
   public ?string $end = null; 


   public function render()
   {
       $searchTerm = '%' . $this->search . '%';

       $query = checkin::with('User', 'Customer')
           ->whereLike(
               [
                   'User.name',
                   'Customer.customer_name'
               ],
               $searchTerm
           )
           ->orderBy('created_at', 'desc'); // Order the results by the most recent 'created_at' date

       // Apply start and end date filters if provided
       if ($this->start && $this->end) {
           $query->whereBetween('created_at', [$this->start, $this->end]);
       } elseif ($this->start) {
           $query->where('created_at', '>=', $this->start);
       } elseif ($this->end) {
           $query->where('created_at', '<=', $this->end);
       }

       $visits = $query->paginate($this->perPage);

       return view('livewire.visits.customer.dashboard', [
           'visits' => $visits,
       ]);
   }

   public function exportCSV($timeInterval = null)
   {
       return Excel::download(new CustomerVisitExport($timeInterval), 'Customers_checkins.xlsx');
   }

   public function exportExcel($timeInterval = null)
   {
       return Excel::download(new CustomerVisitExport($timeInterval), 'Customers_checkins.xlsx');
   }


   public function exportPDF($timeInterval = null)
    {
        $data = $this->getExportData($timeInterval);

        $pdf = PDF::loadView('Exports.visits', ['data' => $data, 'timeInterval' => $timeInterval]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Customers_checkins.pdf');
    }


   protected function getExportData($timeInterval)
   {
        $query = checkin::select('customer_checkin.*', 'users.name')
            ->join('users', 'customer_checkin.user_code', '=', 'users.user_code')
            ->orderBy('customer_checkin.user_code') // Order by user_code (users' codes) in ascending order
            ->orderBy('users.name'); // Order users' names in alphabetical order
        
       if ($timeInterval === 'today') {
           $query->whereDate('customer_checkin.created_at', today());
       } elseif ($timeInterval === 'yesterday') {
           $query->whereDate('customer_checkin.created_at', today()->subDay());
       } elseif ($timeInterval === 'this_week') {
           $query->whereBetween('customer_checkin.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
       } elseif ($timeInterval === 'this_month') {
           $query->whereYear('customer_checkin.created_at', now()->year)->whereMonth('customer_checkin.created_at', now()->month);
       } elseif ($timeInterval === 'this_year') {
           $query->whereYear('customer_checkin.created_at', now()->year);
       }
   
    
       $checkinData = $query->get();
   
       return $checkinData;
   }
   

   
}
