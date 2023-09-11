<?php

namespace App\Http\Livewire\Visits;

use App\Models\VisitsTarget;
use Carbon\Carbon;
use Livewire\Component;

class DashboardView extends Component
{
    public $user_code;
    public $perPage = 10;
    public $search = '';
    public $timeFrame = 'month';
    public $start;
    public $end;
    private $endDate; // Define $endDate as a class property

    public function render()
    {
        $today = Carbon::now();
        $this->endDate = Carbon::now();
        $targetsQuery = VisitsTarget::with('User')->where('user_code', $this->user_code);

        // Apply time frame filter
        $this->applyTimeFrameFilter($targetsQuery);
        $this->Period($targetsQuery, $this->start, $this->end);

        // Fetch targets
        $targets = $targetsQuery->groupBy('Deadline')->get();

        return view('livewire.visits.dashboard-view', [
            'targets' => $targets,
            'today' => $today,
        ]);
    }

    public function Period($query, $start = null, $end = null)
    {
        if (is_null($start) && is_null($end)) {
            return $query;
        }
        if (!is_null($start) && Carbon::parse($start)->isSameDay(Carbon::parse($end))) {
            return $query->where('updated_at', '=', $start);
        }
        if (is_null($start)) {
            $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        if (is_null($end)) {
            $end = Carbon::now()->endOfMonth()->format('Y-m-d');
        }
        return $query->whereBetween('updated_at', [$start, $end]);
    }

    public function updatedTimeFrame()
    {
        $this->render();
    }

    private function applyTimeFrameFilter($query)
    {
        if ($this->timeFrame === 'month') {
            // For the "Month" time frame, show achievements for the current month
            $query->where('Deadline', 'LIKE', "%" . $this->endDate->format('m') . "%");
        } elseif ($this->timeFrame === 'quarter') {
            // For the "Quarter" time frame, group achievements by month within the current quarter
            $currentQuarter = ceil($this->endDate->quarter / 3); // Determine the current quarter
            $startMonth = ($currentQuarter - 1) * 3 + 1; // Calculate the start month of the quarter
            $endMonth = $startMonth + 2; // Calculate the end month of the quarter
            $query->where(function ($query) use ($startMonth, $endMonth) {
                for ($month = $startMonth; $month <= $endMonth; $month++) {
                    $query->orWhere('Deadline', 'LIKE', "%" . $this->endDate->format('Y') . "-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "%");
                }
            });
        } elseif ($this->timeFrame === 'half_year') {
            // For the "Half Year" time frame, group achievements by month within the current half year
            $startMonth = $this->endDate->month <= 6 ? 1 : 7;
            $endMonth = $startMonth + 5; // Calculate the end month of the half year
            $query->where(function ($query) use ($startMonth, $endMonth) {
                for ($month = $startMonth; $month <= $endMonth; $month++) {
                    $query->orWhere('Deadline', 'LIKE', "%" . $this->endDate->format('Y') . "-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "%");
                }
            });
        } elseif ($this->timeFrame === 'year') {
            // For the "Year" time frame, group achievements by month from January to December
            $query->where('Deadline', 'LIKE', "%" . $this->endDate->format('Y') . "-%");
        }
    }

    public function getSuccessRatio($achieved, $target)
    {
        if ($target != 0) {
            return number_format(($achieved / $target) * 100, 2);
        }

        return 0;
    }
}
