<?php

namespace App\Http\Livewire\Leads;

use App\Charts\SalesTargetChart;
use App\Models\SalesTarget;
use Livewire\Component;

class Chart extends Component
{
    public function render()
    {


      $salestargetEx = SalesTarget::with('User')->get();
      $salestarget = new SalesTargetChart();
      $arraySLabel = [];
      $arraySTargets = [];
      $arraySAchieved = [];
      foreach ($salestargetEx as $br) {
         array_push($arraySLabel, $br->User()->pluck('name')->implode(''));
         array_push($arraySTargets, $br->SalesTarget);
         array_push($arraySAchieved, $br->AchievedSalesTarget);
      }
      $salestarget->labels($arraySLabel);
      $salestarget->dataset('Target', 'bar', $arraySTargets)->options([
         "responsive" => true,
         'color' => "#94DB9D",
         'backgroundColor' => "#0739ed",
         "borderWidth" => 2,
         "borderRadius" => 5,
         "borderSkipped" => false,
      ]);
      $salestarget->labels($arraySLabel);
      $salestarget->dataset('Achieved', 'bar', $arraySAchieved)->options([
         "responsive" => true,
         'color' => [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
         ],
         'backgroundColor' => '#07ed41',
         "borderWidth" => 2,
         "borderRadius" => 5,
         "borderSkipped" => false,
      ]);
        return view('livewire.leads.chart',[
         'salestarget' => $salestarget,
        ]);
    }
}
