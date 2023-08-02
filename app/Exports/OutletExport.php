<?php

namespace App\Exports;

use App\Models\OutletType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OutletExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return OutletType::select('id', 'outlet_name')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
        ];
    }
}