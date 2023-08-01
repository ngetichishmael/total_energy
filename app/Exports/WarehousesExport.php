<?php

namespace App\Exports;

use App\Models\warehousing;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WarehousesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return warehousing::with('manager', 'region', 'subregion')
            ->withCount('productInformation')
            ->get()
            ->map(function ($warehouse) {
                return [
                    '#',
                    $warehouse->name,
                    $warehouse->region->name ?? '',
                    $warehouse->subregion->name ?? '',
                    $warehouse->product_information_count > 0 ? $warehouse->product_information_count : '0',
                    $warehouse->status === 'Active' ? 'Active' : 'Disabled',
                ];
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Region',
            'Sub Region',
            'Products Count',
            'Status',
        ];
    }
}
