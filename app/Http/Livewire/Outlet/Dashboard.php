<?php

namespace App\Http\Livewire\Outlet;

use App\Models\OutletType;
use Livewire\Component;
use Livewire\WithPagination;

use App\Exports\OutletExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 40;
    public $sortField = 'id';
    public $sortAsc = true;
    public $search = null;

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';

        $outlets = OutletType::whereLike(['outlet_name'], $searchTerm)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.outlet.dashboard', [
            'outlets' => $outlets
        ]);
    }

    public function exportPDF()
    {
        $searchTerm = '%' . $this->search . '%';

        $outlets = OutletType::whereLike(['outlet_name'], $searchTerm)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->get();

        $pdf = PDF::loadView('Exports.outlets_pdf', compact('outlets'));

        // Download the PDF file
        return response()->streamDownload(function () use ($pdf) {
         echo $pdf->output();
     }, 'outlets.pdf');   
   
   }

   public function export()
   {
       $searchTerm = '%' . $this->search . '%';

       return Excel::download(new OutletExport(), 'outlets.xlsx');
   }

   public function exportCSV()
   {
       $searchTerm = '%' . $this->search . '%';

       return Excel::download(new OutletExport(), 'outlets.csv');
   }

}
