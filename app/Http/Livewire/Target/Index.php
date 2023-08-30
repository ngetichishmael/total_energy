<?php

namespace App\Http\Livewire\Target;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\SalesTarget;
use Livewire\WithPagination;

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

    public function applyFilters()
   {
      $this->resetPage(); // Reset pagination when applying filters
   }

    
    
    
}
