<?php

namespace App\Http\Livewire\Notification\All;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
   use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 7;
    public $sortField = 'id';
    public $sortAsc = true;
    public ?string $search = null;
    public function render()
    {

      $searchTerm = '%' . $this->search . '%';
      $notifications=Notification::whereLike(
         [
             'name',
             'title',
             'body',
             'date',
         ],
         $searchTerm
     )
         ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);
        return view('livewire.notification.all.index',[
         'notifications'=>$notifications
        ]);
    }
}
