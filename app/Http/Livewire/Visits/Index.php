<?php

namespace App\Http\Livewire\Visits;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\VisitationExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $start;
    public $end;
    use WithPagination;
    public function render()
    {
    
        return view('livewire.visits.index', [
            'visits' => $this->data(),
        ]);
    }
    public function data()
    {
        return User::withCount('Checkings')->get();
    }
    public function export()
    {
        return Excel::download(new VisitationExport(), 'visits.xlsx');
    }

    public function exportCSV()
    {
        return Excel::download(new VisitationExport(), 'visits.csv');
    }

    public function exportPDF()
    {
        $data = [
            'visits' => $this->data(),
        ];

        $pdf = Pdf::loadView('Exports.visitation_pdf', $data);

        // Add the following response headers
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'visits.pdf');
    }
}
