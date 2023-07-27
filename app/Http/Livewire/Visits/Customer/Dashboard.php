<?php

namespace App\Http\Livewire\Visits\Customer;

use App\Exports\CustomerVisitExport;
use App\Models\customer\checkin;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

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


   public function export($timeInterval = null)
   {
       return Excel::download(new CustomerVisitExport($timeInterval), 'Customers_checkins.xlsx');
   }
   
}
