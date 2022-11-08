<?php

namespace App\Http\Livewire\Leads;

use App\Models\LeadsTargets;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Targets extends Component
{
   public $QPTargets;
   public $users;
   public $countQPTargets = true;
   protected $rules = [
      'setTargets.*.primarykey' => 'required',
      'setTargets.*.Target' => 'required',
   ];
   public function mount()
   {
      $this->users = User::where('account_type', 'Sales')->get();
      $this->QPTargets = LeadsTargets::all();
      $this->fill([
         'QPTargets' => collect([['primarykey' => '']]),
      ]);
   }

   public function addQPTargets()
   {
      $this->QPTargets->push(new LeadsTargets());
      $this->countQPTargets = true;
   }

   public function removeQPTargets($index)
   {
      $this->QPTargets->pull($index);
      if (count($this->QPTargets) < 1) {
         $this->countQPTargets = false;
      }
   }
   public function submit()
   {
      $today = Carbon::now(); //Current Date and Time

      $lastDayofMonth =    Carbon::parse($today)->endOfMonth()->toDateString();
      $this->validate([
         'QPTargets.*.primarykey' => 'required',
         'QPTargets.*.Target' => 'required',
     ]);
      foreach ($this->DepositTargets as $value) {
         if ($value["primarykey"] === 'ALL') {
            $users = User::where('account_type', 'Sales')->get();
            foreach ($users as $user) {
               LeadsTargets::updateOrCreate(
                  [
                     'user_code' => $user->user_code,
                     'Deadline' => $lastDayofMonth
                  ],
                  [
                     'LeadsTarget' => $value['Target']
                  ]
               );
            }
         } else {
            LeadsTargets::updateOrCreate(
               [
                  'primarykey' => $value["primarykey"],
                  'Deadline' => $lastDayofMonth
               ],
               [
                  'LeadsTarget' => $value['Target']
               ]
            );
         }
      }
      return redirect()->to('/target/sales');
   }
   public function render()
   {
      return view('livewire.leads.targets');
   }
}
