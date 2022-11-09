<?php

namespace App\Http\Livewire\Dashboard;

use App\Charts\SalesTargetChart;
use App\Models\SalesTarget;
use Livewire\Component;

class PercentageTargets extends Component
{

    public function render()
    {
      $salestarget = new SalesTargetChart();
      $salestarget->labels(['Total Sales', 'Total Achieved']);
      $salestarget->dataset("Total Sales", 'pie', [SalesTarget::sum('SalesTarget'),SalesTarget::sum('AchievedSalesTarget')])->options([
         "responsive" => true,
         'color' => "#94DB9D",
         'backgroundColor' =>[
            "#f07d20",
            '#35827b'
         ],
         "borderWidth" => 2,
         "borderRadius" => 5,
         "borderSkipped" => false,
      ]);
        return view('livewire.dashboard.percentage-targets',[
         'total' => $salestarget,
        ]);
    }
}
