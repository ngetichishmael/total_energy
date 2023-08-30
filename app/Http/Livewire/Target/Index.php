<?php

namespace App\Http\Livewire\Target;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\SalesTarget;
use Livewire\WithPagination;

use Excel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class Index extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $start;
    public $end;
    public ?string $search = null;
    public $perPage = 15; 
    
    use WithPagination;



    public function render()
    {
        $query = SalesTarget::query()
            ->whereRaw('AchievedSalesTarget >= SalesTarget');
    
        if ($this->start && $this->end) {
            $query->whereBetween('Deadline', [$this->start, $this->end]);
        }
    
        if ($this->search) {
            $searchTerm = '%' . $this->search . '%';
            $query->whereLike([
                'user.name', 'Deadline'
            ], $searchTerm);
        }
    
        $data = $query->paginate($this->perPage);
    
        return view('livewire.target.index', [
            'targets' => $data
        ]);
    }

    public function exportExcel()
    {
        $data = $this->data();
        $fileName = 'targets.xlsx';

        return Excel::download(new TargetExport($data), $fileName);
    }

    public function exportCsv()
    {
        $data = $this->data();
        $fileName = 'targets.csv';

        return Excel::download(new TargetExport($data), $fileName, \Maatwebsite\Excel\Excel::CSV);
    }

    
    
    
}
