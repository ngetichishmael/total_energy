<?php

namespace App\Exports;

use App\Models\Orders;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{

    /**
    * @return \Illuminate\Support\FromView
    */
    public function view(): View
    {
         return view('Exports.orders', [
            'invoices' => Orders::all()
         ]);

    }
}
