<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Orders;
use App\Models\Customers; 

use App\Models\suppliers\suppliers;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class LineChart extends Component
{
   public function render()
   {
      return view('livewire.dashboard.line-chart', [

         'graphdata' => $this->getGraphData(),
      ]);
   }


   public function getGraphData()
   {
       $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
       ];
   

               $preOrderCounts = Orders::where('order_type', 'Pre Order')
                   ->whereYear('created_at', '=', date('Y'))
                   ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                   ->groupBy('month')
                   ->pluck('count', 'month')
                   ->toArray();

               $deliveryCounts = Orders::where('order_type', 'Pre Order')
                   ->where('order_status', 'DELIVERED')
                   ->whereYear('created_at', '=', date('Y'))
                   ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                   ->groupBy('month')
                   ->pluck('count', 'month')
                   ->toArray();

               $vanSalesCounts = Orders::where('order_type', 'Van Sales')
                   ->whereYear('created_at', '=', date('Y'))
                   ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                   ->groupBy('month')
                   ->pluck('count', 'month')
                   ->toArray();
          
  
       $graphdata = [];
       for ($month = 1; $month <= 12; $month++) {
           $graphdata[] = [
               'month' => $months[$month],
               'preOrderCount' => $preOrderCounts[$month] ?? 0,
               'deliveryCount' => $deliveryCounts[$month] ?? 0,
               'vanSalesCount' => $vanSalesCounts[$month] ?? 0,
           ];
       }

       return $graphdata;
   }
}
