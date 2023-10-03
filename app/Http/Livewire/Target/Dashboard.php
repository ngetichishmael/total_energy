<?php

namespace App\Http\Livewire\Target;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;


class Dashboard extends Component
{
   public $perPage = 10;
   public $search = '';
   public $timeFrame = 'quarter';

   public function render()
   {

      $targetsQuery = User::with('TargetSale')->where('account_type', '<>', 'Admin');
      $today = Carbon::now();
      // $targetsQuery = SalesTarget::query();
      // Apply search filter
      if (!empty($this->search)) {
         $targetsQuery->where('name', 'LIKE', '%' . $this->search . '%');
      }
      // Apply time frame filter
      $this->applyTimeFrameFilter($targetsQuery);
      // Fetch targets
     // $targets = $targetsQuery->get();
      return view('livewire.target.dashboard', [
         'targets' => $this->data(),
         'today' => $today,
      ]);
   }
   public function data()
   {
      
       return User::with('TargetSale')->where('account_type', '<>', 'Admin')->get();
   }

   private function applyTimeFrameFilter($query)
   {
      $endDate = Carbon::now();

      // Set end date based on selected time frame
      if ($this->timeFrame === 'quarter') {
         $endDate->endOfQuarter();
      } elseif ($this->timeFrame === 'half_year') {
         $endMonth = $endDate->month <= 6 ? 6 : 12;
         $endDate->setMonth($endMonth)->endOfMonth();
      } elseif ($this->timeFrame === 'year') {
         $endDate->endOfYear();
      }

      // Apply the filter
      $query->whereHas('TargetSale', function ($targetSaleQuery) use ($endDate) {
         $targetSaleQuery->whereDate('Deadline', '<=', $endDate->format('Y-m-d'));
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
