<?php

namespace App\Http\Livewire\Reports;

use Carbon\Carbon;
use App\Models\Orders;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\PaymentsExport;
use App\Models\Area;
use App\Models\Subregion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class Payments extends Component
{
   protected $paginationTheme = 'bootstrap';
   public $start;
   public $end;
   use WithPagination;
   public function render()
   {
      return view('livewire.reports.payments');
   }
   // public function data()
   // {
   //    $query = Orders::select(
   //       'orders.id',
   //       'customers.customer_name',
   //       'orders.order_code',
   //       'customers.customer_type',
   //       'orders.created_at',
   //       DB::raw('COALESCE(SUM(order_payments.amount), 0) AS total_payment')
   //    )
   //       ->whereIn('orders.customerID', $this->filter())
   //       ->join('customers', 'orders.customerID', '=', 'customers.id')
   //       ->leftJoin('order_payments', 'orders.order_code', '=', 'order_payments.order_id')
   //       ->get();
   //    if (!is_null($this->start)) {
   //       if (Carbon::parse($this->start)->equalTo(Carbon::parse($this->end))) {
   //          $query->whereDate('created_at', 'LIKE', "%" . $this->start . "%");
   //       } else {
   //          if (is_null($this->end)) {
   //             $this->end = Carbon::now()->endOfMonth()->format('Y-m-d');
   //          }
   //          $query->whereBetween('created_at', [$this->start, $this->end]);
   //       }
   //    }

   //    return $query;
   // }
   // public function filter(): array
   // {

   //    $array = [];
   //    $user = Auth::user();
   //    $user_code = $user->route_code;
   //    if (!$user->account_type === 'RSM') {
   //       return $array;
   //    }
   //    $subregions = Subregion::where('region_id', $user_code)->pluck('id');
   //    if ($subregions->isEmpty()) {
   //       return $array;
   //    }
   //    $areas = Area::whereIn('subregion_id', $subregions)->pluck('id');
   //    if ($areas->isEmpty()) {
   //       return $array;
   //    }
   //    $customers = customers::whereIn('route_code', $areas)->pluck('id');
   //    if ($customers->isEmpty()) {
   //       return $array;
   //    }
   //    return $customers->toArray();
   // }
   // public function export()
   // {
   //    return Excel::download(new PaymentsExport, 'Payments.xlsx');
   // }
   public function export()
   {
       return Excel::download(new PaymentsExport(), 'payments.xlsx');
   }

   public function exportCSV()
   {
       return Excel::download(new PaymentsExport(), 'payments.csv');
   }

   public function exportPDF()
   {
       $data = [
           'payments' => $this->data(),
       ];

       $pdf = Pdf::loadView('Exports.payments_pdf', $data);

       // Add the following response headers
       return response()->streamDownload(function () use ($pdf) {
           echo $pdf->output();
       }, 'payments.pdf');
   }

}
