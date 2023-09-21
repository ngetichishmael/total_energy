<?php

namespace App\Exports;
use App\Models\warehousing;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\FromCollection;

class PaymentsExport implements FromView, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function map($payments): array
    {
        return [
            $payments->customer_name,
            $payments->order_id,
            $payments->added_by,
            $payments->status,
            optional($payments->Area->Subregion->Region)->name,
            optional($payments->Area->Subregion)->name,
            optional($payments->Area)->name,
            optional($payments->Creator)->name,
            optional($payments)->created_at,
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

        $payments = $query->get();

        return view('Exports.payments', [
            'payments' =>  $payments, 
        ]);
    }
}
