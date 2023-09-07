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

    public function render()
    {
        $today = Carbon::now();
        $targetsQuery = VisitsTarget::with('User')->where('user_code', $this->user_code);

        // Apply time frame filter
        $this->applyTimeFrameFilter($targetsQuery);
        $this->Period($targetsQuery, $this->start, $this->end);

        // Fetch targets
        $targets = $targetsQuery->get();

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
        $endDate = Carbon::now();

        if ($this->timeFrame === 'month') {
            // For the "Month" time frame, show achievements for the current month
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($this->timeFrame === 'quarter') {
            // For the "Quarter" time frame, group achievements by month within the current quarter
            $startMonth = ($endDate->quarter - 1) * 3 + 1; // Calculate the start month of the quarter
            $startDate = Carbon::now()->startOfYear()->month($startMonth);
            $endDate = $startDate->copy()->addMonths(2)->endOfMonth(); // Set the end date to the last day of the quarter
        } elseif ($this->timeFrame === 'half_year') {
            // For the "Half Year" time frame, group achievements by month within the current half year
            $startMonth = $endDate->month <= 6 ? 1 : 7;
            $startDate = Carbon::now()->startOfYear()->month($startMonth);
            $endDate = $startDate->copy()->addMonths(5)->endOfMonth(); // Set the end date to the last day of the half year
        } elseif ($this->timeFrame === 'year') {
            // For the "Year" time frame, group achievements by month from January to December
            $startDate = Carbon::now()->startOfYear();
            $endDate = $startDate->copy()->endOfYear();
        }

        // Apply the filter
        $query->whereDate('Deadline', '>=', $startDate->format('Y-m-d'))
            ->whereDate('Deadline', '<=', $endDate->format('Y-m-d'));
    }

    public function getSuccessRatio($achieved, $target)
    {
        if ($target != 0) {
            return number_format(($achieved / $target) * 100, 2);
        }

        return 0;
    }
}
