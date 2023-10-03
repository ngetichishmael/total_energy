<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use App\Models\warehousing;
use App\Exports\InventoryExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class Inventory extends Component
{
    public function render()
    {
        //$warehouses = warehousing::whereNotNull('warehouse_code')->distinct('name')->get();
        $count = 1;
        return view('livewire.reports.inventory', ['warehouses' => $this->data(), 'count' => $count]);
    }
    public function data()
    {
       
        return warehousing::whereNotNull('warehouse_code')->distinct('name')->get();
    }
    public function export()
    {
        return Excel::download(new InventoryExport(), 'inventory.xlsx');
    }

    public function exportCSV()
    {
        return Excel::download(new InventoryExport(), 'inventory.csv');
    }

    public function exportPDF()
    {
        $data = [
            'warehouses' => $this->data(),
        ];

        $pdf = Pdf::loadView('Exports.inventory', $data);

        // Add the following response headers
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'inventory.pdf');
    }
}
