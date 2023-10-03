<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\OrdersTarget; 
use App\Models\SalesTarget; 
use App\Models\VisitsTarget; 
use App\Models\LeadsTargets; 

use Carbon\Carbon;

class ResetTargets extends Command
{
    protected $signature = 'reset:targets';

    protected $description = 'Reset Targets';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

          // Get the current month and year
            $currentMonth = Carbon::now()->format('Y-m');

            // Get users meeting the criteria
            $users = User::where(function ($query) {
                $query->whereIn('account_type', ['Lube Sales Executive', 'Lube Merchandizers'])
                    ->where('status', 'Active');
            })->get();

              foreach ($users as $user) {
                  // Check if there is an existing record for the current month
                  $existingRecord = OrdersTarget::where('user_code', $user->user_code)
                      ->where('Deadline', 'LIKE', $currentMonth . '-%')
                      ->first();
      
                  if ($existingRecord) {
                      // There is an existing record for the current month, do nothing
                      continue;
                  }
      
                  // Create a new record for the current month
                  OrdersTarget::create([
                      'user_code' => $user->user_code,
                      'OrdersTarget' => 20000,
                      'AchievedOrdersTarget' => 0,
                      'Deadline' => Carbon::now()->endOfMonth()->toDateString(),
                  ]);
              }

              foreach ($users as $user) {
                // Check if there is an existing record for the current month
                $existingRecord = SalesTarget::where('user_code', $user->user_code)
                    ->where('Deadline', 'LIKE', $currentMonth . '-%')
                    ->first();
    
                if ($existingRecord) {
                    // There is an existing record for the current month, do nothing
                    continue;
                }
    
                // Create a new record for the current month
                SalesTarget::create([
                    'user_code' => $user->user_code,
                    'SalesTarget' => 50000, 
                    'AchievedSalesTarget' => 0,
                    'Deadline' => Carbon::now()->endOfMonth()->toDateString(),
                ]);
             }

             foreach ($users as $user) {
                // Check if there is an existing record for the current month
                $existingRecord = VisitsTarget::where('user_code', $user->user_code)
                    ->where('Deadline', 'LIKE', $currentMonth . '-%')
                    ->first();
    
                if ($existingRecord) {
                    // There is an existing record for the current month, do nothing
                    continue;
                }
    
                // Create a new record for the current month
                VisitsTarget::create([
                    'user_code' => $user->user_code,
                    'VisitsTarget' => 10000, 
                    'AchievedVisitsTarget' => 0, 
                    'Deadline' => Carbon::now()->endOfMonth()->toDateString(),
                ]);
            }

            foreach ($users as $user) {
                // Check if there is an existing record for the current month
                $existingRecord = LeadsTargets::where('user_code', $user->user_code)
                    ->where('Deadline', 'LIKE', $currentMonth . '-%')
                    ->first();
    
                if ($existingRecord) {
                    // There is an existing record for the current month, do nothing
                    continue;
                }
    
                // Create a new record for the current month
                LeadsTargets::create([
                    'user_code' => $user->user_code,
                    'LeadsTarget' => 5000,
                    'AchievedLeadsTarget' => 0, 
                    'Deadline' => Carbon::now()->endOfMonth()->toDateString(),
                ]);
            }
      
              $this->info('Targets.');
    }
}
