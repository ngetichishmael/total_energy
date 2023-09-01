<?php

namespace App\Http\Livewire\Visits;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $start;
    public $end;
    use WithPagination;
    public function render()
    {
        return view('livewire.visits.index', [
            'visits' => $this->data(),
        ]);
    }
    public function data()
    {
        return User::withCount('Checkings')->get();
    }
}
