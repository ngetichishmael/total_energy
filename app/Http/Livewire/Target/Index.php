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
    public $search = '';
    public $perPage = 15; // Set a default per page value
    
    use WithPagination;

    public function updatedStart($value)
   {
      $this->start = $value;
   }

   public function updatedEnd($value)
   {
      $this->end = $value;
   }


   public function render()
    {
        return view('livewire.target.index', [
            'targets' => $this->data()
        ]);
    }

    public function data()
    {
        $query = SalesTarget::query()
            ->whereRaw('AchievedSalesTarget >= SalesTarget');
    
        if ($this->start && $this->end) {
            $query->whereBetween('created_at', [$this->start, $this->end]);
        }
    
        if ($this->search) {
            $query->whereHas('user', function ($subquery) {
                $subquery->where('name', 'like', '%' . $this->search . '%');
            });
        }
    
        return $query->paginate($this->perPage);
    }
    
    
}
