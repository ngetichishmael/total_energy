<?php

namespace App\Exports;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Models\Orders;
use App\Models\Subregion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromView, WithMapping
{
       /**
    * @return \Illuminate\Support\Collection
    */
    public function map($users): array
    {
        return [
            $delivery->order_code,
            $delivery->order_status,
            $delivery->Customer->customer_name,
            $delivery->User->name,
            $delivery->User->account_type,
            optional($delivery->Area->Subregion->Region)->name,
            optional($delivery->Area->Subregion)->name,
            optional($delivery->Area)->name,
            optional($delivery->Creator)->name,
            optional($delivery)->created_at,
        ];
    }

    protected $timeInterval;

    public function __construct($timeInterval = null)
    {
        $this->timeInterval = $timeInterval;
    }

    public function view(): View
    {

        $query = User::whereNotNull('user_code')
        ->where('route_code', '=', Auth::user()->route_code)
        ->select('account_type', DB::raw('COUNT(*) as count'))
        ->groupBy('account_type');
        

        $users = $query->get();

        return view('Exports.users', [
            'users' =>  $users, 
        ]);
    }
}
