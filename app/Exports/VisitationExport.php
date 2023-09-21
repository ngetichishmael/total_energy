<?php

namespace App\Exports;
use App\Models\Area;
use App\Models\User;
use App\Models\Orders;
use App\Models\Subregion;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class VisitationExport implements FromView, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function map($visitation): array
    {
        return [
            $visits->name,
            $visits->account_type,
            $visits->checkings_count,
            optional($visits->Area->Subregion->Region)->name,
            optional($visits->Area->Subregion)->name,
            optional($visits->Area)->name,
            optional($visits->Creator)->name,
            optional($visits)->created_at,
        ];
    }

    protected $timeInterval;

    public function __construct($timeInterval = null)
    {
        $this->timeInterval = $timeInterval;
    }

    public function view(): View
    {

      $query = User::withCount('Checkings');
        $visits = $query->get();

        return view('Exports.visitation', [
            'visits' =>  $visits, 
        ]);
    }
}
