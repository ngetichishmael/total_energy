<?php

namespace App\Http\Livewire\Target;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

use Excel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class Index extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $start;
    public $end;
<<<<<<< HEAD
    public ?string $search = null;
    public $perPage = 15; 
    
    use WithPagination;



    public function render()
    {
        $query = SalesTarget::query()
            ->whereRaw('AchievedSalesTarget >= SalesTarget');
    
        if ($this->start && $this->end) {
            $query->whereBetween('Deadline', [$this->start, $this->end]);
        }
    
        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';
            $query->whereLike([
                'user.name', 'Deadline'
            ], $searchTerm);
        }
    
        $data = $query->paginate($this->perPage);
    
        return view('livewire.target.index', [
            'targets' => $data
        ]);
    }

    public function exportExcel()
    {
        $data = $this->data; // Change data() to data
        $fileName = 'targets.xlsx';
    
        return Excel::download(new TargetExport($data), $fileName);
    }
    
    public function exportCsv()
    {
        $data = $this->data; // Change data() to data
        $fileName = 'targets.csv';
    
        return Excel::download(new TargetExport($data), $fileName, \Maatwebsite\Excel\Excel::CSV);
    }
    

    
    
    
=======
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
>>>>>>> origin/ish
}
