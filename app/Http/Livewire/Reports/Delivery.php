<?php

namespace App\Http\Livewire\Reports;

use App\Models\Area;
use App\Models\Orders;
use App\Models\Subregion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\DeliveryExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class Delivery extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $start;
    public $end;
    public function render()
    {
        $count = 1;
        return view('livewire.reports.delivery', [
            'deliveries' => $this->data(),
            'count' => $count,
        ]);
    }
    public function data()
    {
        $query = Orders::with('User', 'Customer')->where('order_status', "LIKE", '%Deliver%');
        if (!is_null($this->start)) {
            if (Carbon::parse($this->start)->equalTo(Carbon::parse($this->end))) {
                $query->whereDate('created_at', 'LIKE', "%" . $this->start . "%");
            } else {
                if (is_null($this->end)) {
                    $this->end = Carbon::now()->endOfMonth()->format('Y-m-d');
                }
                $query->whereBetween('created_at', [$this->start, $this->end]);
            }
        }

        return $query->orderBy('id', 'DESC')->paginate(10);
    }
    public function details($code)
    {
        $order = Orders::with('orderItems.Information')->where('order_code', $code)->first();

        if (!isset($order->orderItems)) {
            return 0;
        }

        $orderItems = $order->orderItems;
        $total = 0;
        foreach ($orderItems as $item) {
            $numericSku = intval(preg_replace('/[^0-9]/', '', $item->Information->sku_code));
            $total += $numericSku;
        }
        return $total;
    }

    public function filter(): array
    {

        $array = [];
        $user = Auth::user();
        $user_code = $user->route_code;
        if (!$user->account_type === 'RSM') {
            return $array;
        }
        $subregions = Subregion::where('region_id', $user_code)->pluck('id');
        if ($subregions->isEmpty()) {
            return $array;
        }
        $areas = Area::whereIn('subregion_id', $subregions)->pluck('id');
        if ($areas->isEmpty()) {
            return $array;
        }
        $customers = customers::whereIn('route_code', $areas)->pluck('id');
        if ($customers->isEmpty()) {
            return $array;
        }
        return $customers->toArray();
    }
    public function export()
    {
        return Excel::download(new DeliveryExport(), 'delivery.xlsx');
    }

    public function exportCSV()
    {
        return Excel::download(new DeliveryExport(), 'delivery.csv');
    }

    public function exportPDF()
    {
        $data = [
            'deliveries' => $this->data(),
        ];

        $pdf = Pdf::loadView('Exports.delivery_pdf', $data);

        // Add the following response headers
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'delivery.pdf');
    }
}
