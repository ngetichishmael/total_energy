<?php

namespace App\Exports;
use App\Models\Area;
use App\Models\Orders;
use App\Models\Subregion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\FromCollection;

class VansalesExport implements FromView, WithMapping
{
        /**
    * @return \Illuminate\Support\Collection
    */
    public function map($vansales): array
    {
        return [
            $vansales->customer_name,
            $vansales->order_code,
            $vansales->Customer->customer_name,
            $vansales->User->name,
            $vansales->User->account_type,
            optional($vansales->Area->Subregion->Region)->name,
            optional($vansales->Area->Subregion)->name,
            optional($vansales->Area)->name,
            optional($vansales->Creator)->name,
            optional($vansales)->created_at,
        ];
    }

    protected $timeInterval;
    

    public function __construct($timeInterval = null)
    {
        $this->timeInterval = $timeInterval;
    }

    public function view(): View
    {
        $query = Orders::with('User', 'Customer')->where('order_type', 'Van sales');

        $vansales = $query->get();

        return view('Exports.vansales', [
            'vansales' =>  $vansales, 
        ]);
    }
}