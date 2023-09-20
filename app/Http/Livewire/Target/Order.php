<?php

namespace App\Http\Livewire\Target;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan; // Import the Artisan facade
use Livewire\Component;

class Order extends Component
{
    public $perPage = 20;
    public $search = '';
    public $timeFrame = 'month';

    public function render()
    {
        $targetsQuery = User::with('TargetsOrder')->where('account_type', '<>', 'Admin');
        $today = Carbon::now();

        // Apply search filter
        if (!empty($this->search)) {
            $targetsQuery->where('name', 'LIKE', '%' . $this->search . '%');
        }

        // Apply time frame filter
        $this->applyTimeFrameFilter($targetsQuery);

        // Fetch targets
        $targets = $targetsQuery->get();

        return view('livewire.target.order', [
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

        // Apply the filter
        $query->whereHas('TargetsOrder', function ($targetSaleQuery) use ($endDate) {
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

    public function resetTargets()
    {
        // Run the Artisan command to reset targets
        Artisan::call('reset:targets');
        
        // Optional: You can add a success message or redirect back to the page.
    }
}
