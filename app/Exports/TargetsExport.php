<?php

namespace App\Exports;
use App\Models\Area;
use App\Models\Orders;
use App\Models\Subregion;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\FromCollection;

class TargetsExport implements FromView, WithMapping
{
    /**
 * @return \Illuminate\Support\Collection
 */
 public function map($targets): array
 {
     return [
        $targets->name,
        $targets->orders_target,
        $targets->leads_target,
        $targets->sales_target,
        $targets->visits_target,
        $targets->achieved_leads_target,
        $targets->achieved_orders_target,
        $targets->achieved_sales_target,
        $targets->achieved_visits_target,
        $targets->account_type,
         optional($targets->Area->Subregion->Region)->name,
         optional($targets->Area->Subregion)->name,
         optional($targets->Area)->name,
         optional($targets->Creator)->name,
         optional($targets)->created_at,
     ];
 }

 protected $timeInterval;

 public function __construct($timeInterval = null)
 {
     $this->timeInterval = $timeInterval;
 }

 public function view(): View
 {

    $query = User::join('leads_targets', 'users.user_code', '=', 'leads_targets.user_code')
    ->join('orders_targets', 'users.user_code', '=', 'orders_targets.user_code')
    ->join('sales_targets', 'users.user_code', '=', 'sales_targets.user_code')
    ->join('visits_targets', 'users.user_code', '=', 'visits_targets.user_code')
    ->select(
        'users.name as name',
        'users.account_type as account_type',
        'leads_targets.LeadsTarget as leads_target',
        'leads_targets.AchievedLeadsTarget as achieved_leads_target',
        'orders_targets.OrdersTarget as orders_target',
        'orders_targets.AchievedOrdersTarget as achieved_orders_target',
        'sales_targets.SalesTarget as sales_target',
        'sales_targets.AchievedSalesTarget as achieved_sales_target',
        'visits_targets.VisitsTarget as visits_target',
        'visits_targets.AchievedVisitsTarget as achieved_visits_target'
    );

     $targets = $query->get();

     return view('Exports.targets', [
         'targets' =>  $targets, 
     ]);
 }
}
