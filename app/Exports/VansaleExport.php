<?php

namespace App\Exports;

use App\Models\Orders;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VansaleExport implements FromView
{

    /**
     * @return \Illuminate\Support\FromView
     */
    public function view(): View
    {
        return view('Exports.vansales', [
            'vansales' => Orders::with('User', 'Customer')->withCount('OrderItems')->where('order_type', 'Van sales')->get(),
        ]);

    }
}
