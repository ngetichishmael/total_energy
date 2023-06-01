<?php

namespace App\Http\Livewire\Leads;

use App\Models\LeadsTargets;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Targets extends Component
{
   public $Targets;
   public $users;
   // public $QPTargets;
   public $countTargets = true;
   public function mount()
   {

      $today = Carbon::now();
      $lastDayofMonth =  Carbon::parse($today)->endOfMonth()->toDateString();
      $this->users = User::where('account_type','<>', 'Admin')->get();
      $this->fill([
         'Targets' => collect([
            ['primarykey' => '', 'deadline' => $lastDayofMonth]
         ]),
      ]);
   }

   public function addTargets()
   {
      $this->Targets->push(new LeadsTargets());
      $this->countTargets = true;
   }

   public function removeTargets($index)
   {
      $this->Targets->pull($index);
      if (count($this->Targets) < 1) {
         $this->countTargets = false;
      }
   }
   public function submit()
   {
      $today = Carbon::now(); //Current Date and Time

      $lastDayofMonth =    Carbon::parse($today)->endOfMonth()->toDateString();
      $this->validate([
         'Targets.*.primarykey' => 'required',
         'Targets.*.deadline' => 'required',
         'Targets.*.Target' => 'required',
      ]);
      foreach ($this->Targets as $value) {
         if ($value["primarykey"] === 'ALL') {
            $users = User::where('account_type','<>', 'Admin')->get();
            foreach ($users as $user) {
               LeadsTargets::updateOrCreate(
                  [
                     'user_code' => $user->user_code,
                     'Deadline' => $value['deadline'] ?? $lastDayofMonth
                  ],
                  [
                     'LeadsTarget' => $value['Target']
                  ]
               );
            }
         } else {
            LeadsTargets::updateOrCreate(
               [
                  'user_code' => $value["primarykey"],
               ],
               [
                  'Deadline' =>  $value['deadline'] ?? $lastDayofMonth,
                  'LeadsTarget' => $value['Target']
               ]
            );
         }
      }
      return redirect()->to('/target/leads');
   }
   public function render()
   {
      return view('livewire.leads.targets');
   }
}
