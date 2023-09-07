<?php

namespace App\Http\Livewire\Target;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Lead extends Component
{
    public $perPage = 10;
    public $search = '';
    public $timeFrame = 'quarter';

    public function render()
    {

        $targetsQuery = User::with('TargetLead')->where('account_type', '<>', 'Admin');
        $today = Carbon::now();
        // $targetsQuery = SalesTarget::query();
        // Apply search filter
        if (!empty($this->search)) {
            $targetsQuery->where('name', 'LIKE', '%' . $this->search . '%');
        }
        // Apply time frame filter
        $this->applyTimeFrameFilter($targetsQuery);
        // Fetch targets
        $targets = $targetsQuery->get();
        return view('livewire.target.lead', [
            'targets' => $targets,
            'today' => $today,
        ]);
    }

    private function applyTimeFrameFilter($query)
    {
        $endDate = Carbon::now();
        if ($this->timeFrame === 'quarter') {
            $endDate->endOfQuarter();
        } elseif ($this->timeFrame === 'half_year') {
            $endMonth = $endDate->month <= 6 ? 6 : 12;
            $endDate->setMonth($endMonth)->endOfMonth();
        } elseif ($this->timeFrame === 'year') {
            $endDate->endOfYear();
        } elseif ($this->timeFrame === 'month') {
            $endDate->endOfMonth();
        }
        $query->whereHas('TargetLead', function ($targetSaleQuery) use ($endDate) {
            $targetSaleQuery->where('Deadline', 'LIKE', "%" . $endDate->format('m') . "%");

        });
    }
    public function getSuccessRatio($achieved, $target)
    {
        if ($target != 0) {
            return number_format(($achieved / $target) * 100, 2);
        }

        return 0;
    }
}
