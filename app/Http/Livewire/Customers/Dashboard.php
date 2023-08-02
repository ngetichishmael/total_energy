<?php

namespace App\Http\Livewire\Customers;

use App\Exports\CustomersExport;

use App\Models\Area;
use App\Models\customers;
use App\Models\Subregion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\View;
use PDF;
use Carbon\Carbon;

class Dashboard extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public ?string $search = null;
   public $regionFilter = null;
   public $subregionFilter = null;
   public $areaFilter = null; 

   public $start = null;
   public $end = null;

   public function render()
   {
      $subregions = Subregion::all(); 

      $areasInSubregion = collect([]);
      if ($this->subregionFilter) {
          $areasInSubregion = Area::where('subregion_id', $this->subregionFilter)->get();
      }

      return view('livewire.customers.dashboard', [
         'contacts' => $this->getCustomer(),
         'subregions' => $subregions, 
         'areasInSubregion' => $areasInSubregion,
      ]);
   }

   public function export()
   {
       return Excel::download(new CustomersExport(), 'customers.xlsx');
   }

   public function exportCSV()
   {
       return Excel::download(new CustomersExport(), 'customers.csv');
   }

   public function exportPDF()
   {
       $data = [
           'contacts' => $this->getCustomer(),
       ];
   
       $pdf = PDF::loadView('Exports.customer_pdf', $data);
   
       // Add the following response headers
       return response()->streamDownload(function () use ($pdf) {
           echo $pdf->output();
       }, 'customers.pdf');
   }

   public function deactivate($id)
   {
      customers::whereId($id)->update(
         ['approval' => "Suspended"]
      );
      session()->flash('success', 'Disabled successfully.');
      return redirect()->to('/customer');
   }
   public function activate($id)
   {
      customers::whereId($id)->update(
         ['approval' => "Approved"]
      );
      session()->flash('success', 'Activated successfully.');
      return redirect()->to('/customer');
   }
 


   public function areas()
   {
       $user = Auth::user();
       $subregions = Subregion::where('region_id', $user->route_code)->pluck('id');

       // Apply Subregion filter if selected
       if ($this->subregionFilter) {
           $areas = Area::where('subregion_id', $this->subregionFilter)->pluck('id');
       } else {
           $areas = Area::whereIn('subregion_id', $subregions)->pluck('id');
       }

       return $areas;
   }

   public function getCustomer()
   {
       $searchTerm = '%' . $this->search . '%';
       $query = customers::orderBy('created_at', 'DESC'); // Order by created_at in descending order (most recent first)
   
       // Apply the search term filter
       $query->where(function ($q) use ($searchTerm) {
           $q->where('customer_name', 'LIKE', $searchTerm)
             ->orWhere('address', 'LIKE', $searchTerm)
             ->orWhere('phone_number', 'LIKE', $searchTerm);
       });
   
       // Check if filters are provided from Blade view
       if ($this->subregionFilter || $this->areaFilter || $this->start || $this->end) {
           // Apply the date filters if provided
           if ($this->start && $this->end) {
               $query->whereBetween('created_at', [$this->start, $this->end]);
           } elseif ($this->start) {
               $query->where('created_at', '>=', $this->start);
           } elseif ($this->end) {
               $query->where('created_at', '<=', $this->end);
           }
   
           // Apply Subregion and Area filters if selected
           if ($this->subregionFilter) {
               $areasInSubregion = Area::where('subregion_id', $this->subregionFilter)->pluck('id');
               if ($this->areaFilter) {
                   // Apply the selected Area filter
                   $query->where('unit_id', $this->areaFilter);
               } else {
                   // Apply the areas belonging to the selected Subregion
                   $query->whereIn('unit_id', $areasInSubregion);
               }
           } else {
               // Apply the default areas based on the user's route code
               $query->whereIn('unit_id', $this->areas());
           }
       }
   
       $contacts = $query->paginate($this->perPage);
       return $contacts;
   }
   
   
   
   
}
