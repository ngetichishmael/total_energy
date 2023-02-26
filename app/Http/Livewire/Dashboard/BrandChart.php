<?php

namespace App\Http\Livewire\Dashboard;

use App\Charts\BrandSales;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BrandChart extends Component
{
   public function render()
   {
      $brands = DB::table('order_items')->select('product_name', DB::raw('SUM(total_amount) as total'))
         ->groupBy('product_name')
         ->orderBy('total', 'desc')
         ->limit(7)
         ->get();
      $catergories = DB::table('order_items')->select('product_name', DB::raw('SUM(total_amount) as total'))
         ->groupBy('product_name')
         ->orderBy('total', 'asc')
         ->limit(7)
         ->get();
      $arrayLabel = [];
      $arrayData = [];
      $arrayCLabel = [];
      $arrayCData = [];
      foreach ($brands as $br) {
         array_push($arrayLabel, $br->product_name);
         array_push($arrayData, $br->total);
      }
      foreach ($catergories as $br) {
         array_push($arrayCLabel, $br->product_name);
         array_push($arrayCData, $br->total);
      }
      $brandsales = new BrandSales();
      $brandsales->labels($arrayLabel);
      $brandsales->dataset('Best Performing Brand', 'bar', $arrayData)->options([
         "responsive" => true,
         'color' => "#94DB9D",
         'backgroundColor' => '#009dde',
         "borderWidth" => 2,
         "borderRadius" => 5,
         "borderSkipped" => true,
      ]);
      $brandsales->labels(array_reverse($arrayCLabel));
      $brandsales->dataset('Least Performing Brand', 'bar', array_reverse($arrayCData))->options([
         "responsive" => true,
         'color' => "#94DB9D",
         'backgroundColor' => '#f07f21',
         "borderWidth" => 2,
         "borderSkipped" => true,
      ]);
      return view('livewire.dashboard.brand-chart', [
         'brandsales' => $brandsales,
      ]);
   }
}
