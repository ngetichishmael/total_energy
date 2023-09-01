<?php

namespace App\Exports;

use App\Models\SalesTarget;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TargetExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            '#',
            'User Name',
            'Target',
            'Achieved',
            'Deadline',
        ];
    }
}
