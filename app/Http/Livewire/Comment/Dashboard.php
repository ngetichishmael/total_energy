<?php

namespace App\Http\Livewire\Comment;

use App\Models\CustomerComment;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{

   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public ?string $search = null;
   public function render()
   {
      $searchTerm = '%' . $this->search . '%';
      $comments = CustomerComment::with('User', 'Customer')
         ->search($searchTerm)
         ->paginate($this->perPage);
      return view('livewire.comment.dashboard', [
         'comments' => $comments
      ]);
   }
}
