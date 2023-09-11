<?php

namespace App\Exports;

// use App\Models\customer\customers;
use App\Models\Area;
use App\Models\customers;
use App\Models\Subregion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromView, WithMapping
{
    public function map($contacts): array
    {
        return [
            $contacts->customer_name,
            $contacts->phone_number,
            $contacts->order_count ,
            $contacts->last_ordering_date,
            optional($contacts->Area->Subregion->Region)->name,
            optional($contacts->Area->Subregion)->name,
            optional($contacts->Area)->name,
            optional($contacts->Creator)->name,
            optional($contacts)->created_at,
        ];
    }

    protected $timeInterval;
    protected $orderAsc;


    public function __construct($timeInterval = null)
    {
        $this->timeInterval = $timeInterval;
    }

    public function view(): View
    {
        $query = Customers::withCount('Orders')
        ->whereHas('Orders')
        ->leftJoin('orders', 'customers.id', '=', 'orders.customerID')
        ->selectRaw(
            'customers.customer_name as customer_number,
            customers.phone_number as phonenumber,
            COUNT(orders.id) as order_count,
            MAX(orders.delivery_date) as last_ordering_date'
        )
        ->groupBy(
            'customers.id',
            'customers.soko_uuid',
            'customers.external_uuid',
            'customers.source',
            'customers.customer_name',
            'customers.account',
            'customers.manufacturer_number',
            'customers.vat_number',
            'customers.approval',
            'customers.delivery_time'
        )
        ->orderBy('order_count', $this->orderAsc ? 'asc' : 'desc');

        $contacts = $query->get();

        return view('Exports.customers', [
            'contacts' => $contacts, 
        ]);
    }
}
