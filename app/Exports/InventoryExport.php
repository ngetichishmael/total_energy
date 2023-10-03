<?php

namespace App\Exports;
use App\Models\warehousing;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\FromCollection;

class InventoryExport implements FromView, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function map($warehouses): array
    {
        return [
            $warehouse->name,
            optional($warehouses->Area->Subregion->Region)->name,
            optional($warehouses->Area->Subregion)->name,
            optional($warehouses->Area)->name,
            optional($warehouses->Creator)->name,
            optional($warehouses)->created_at,
        ];
    }

    protected $timeInterval;

    public function __construct($timeInterval = null)
    {
        $this->timeInterval = $timeInterval;
    }

    public function view(): View
    {
        $query = warehousing::whereNotNull('warehouse_code')->distinct('name');

        $warehouses = $query->get();

        return view('Exports.inventory', [
            'warehouses' =>  $warehouses, 
        ]);
    }
}

