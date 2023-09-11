<?php

namespace App\Exports;
use App\Models\Area;
use App\Models\Orders;
use App\Models\Subregion;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\FromCollection;

class DeliveryExport implements FromView, WithMapping
{
       /**
    * @return \Illuminate\Support\Collection
    */
    public function map($deliveries): array
    {
        return [
            $deliveries->order_code,
            $deliveries->order_status,
            $deliveries->Customer->customer_name,
            $deliveries->User->name,
            $deliveries->User->account_type,
            optional($deliveries->Area->Subregion->Region)->name,
            optional($deliveries->Area->Subregion)->name,
            optional($deliveries->Area)->name,
            optional($deliveries->Creator)->name,
            optional($deliveries)->created_at,
        ];
    }

    protected $timeInterval;

    public function __construct($timeInterval = null)
    {
        $this->timeInterval = $timeInterval;
    }

    public function view(): View
    {

        $query = Orders::with('User', 'Customer')->where('order_status', "LIKE", '%Deliver%');

        $deliveries = $query->get();

        return view('Exports.delivery', [
            'deliveries' =>  $deliveries, 
        ]);
    }
}
