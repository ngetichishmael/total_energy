<?php

namespace App\Http\Livewire\Target;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $start;
    public $end;
    use WithPagination;
    public function render()
    {
        return view('livewire.target.index', [
            'targets' => $this->data(),
        ]);
    }
    public function data()
    {
        $data = User::join('leads_targets', 'users.user_code', '=', 'leads_targets.user_code')
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
            )
            ->paginate(10);

        return $data;
    }
}
