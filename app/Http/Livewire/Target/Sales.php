<?php

namespace App\Http\Livewire\Target;

use App\Models\User;
use Livewire\Component;

class Sales extends Component
{
   public $perPage = 10;
   public $search = '';
   public $orderBy = 'proID';
   public $orderAsc = true;
   public $salesperson;
    public $target;


   protected $rules = [
      'salesperson' => 'required|min:6',
      'target' => 'required|email',
  ];

    public function render()
    {
        return view('livewire.target.sales');
    }
    public function mount()
    {
      $this->users=User::where('account_type','Sales')->get();
    }

    public function newTarget()
    {
      $this->validate();

    }
}
