<?php

namespace App\Exports;
use App\Models\Area;
use App\Models\Orders;
use App\Models\Subregion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\FromCollection;

class PreOrdersExport implements FromView, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function map($preorders): array
    {
        return [
            $preorders->customer_name,
            $preorders->order_id,
            $preorders->added_by,
            $preorders->status,
            optional($preorders->Area->Subregion->Region)->name,
            optional($preorders->Area->Subregion)->name,
            optional($preorders->Area)->name,
            optional($preorders->Creator)->name,
            optional($preorders)->created_at,
        ];
    }

    protected $timeInterval;

    public function __construct($timeInterval = null)
    {
        $this->timeInterval = $timeInterval;
    }

    public function view(): View
    {
        $query = Orders::whereHas('User')->whereHas('Customer')->with('User', 'Customer')->where('order_type', 'Pre Order');

        $preorders = $query->get();

        return view('Exports.preorders', [
            'orders' =>  $preorders, 
        ]);
    }
}
