<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AssignDefaultTarget extends Command
{
    protected $signature = 'assign:default-target';
    protected $description = 'Assign default target of 100 with end-of-month deadline to users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $defaultTarget = 100;
        $now = Carbon::now();

        // Calculate end of the current month
        $endOfMonth = $now->endOfMonth()->toDateString();

        // Assuming 'users' table has 'user_code' column
        $users = DB::table('users')
            ->whereNotIn('account_type', ['Admin', 'Managers'])
            ->select('user_code')
            ->get();

        foreach ($users as $user) {
            // Insert a new row in the respective targets table with end-of-month deadline and timestamps
            DB::table('leads_targets')->insert([
                'user_code' => $user->user_code,
                'LeadsTarget' => $defaultTarget,
                'AchievedLeadsTarget' => '0',
                'Deadline' => $endOfMonth,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('orders_targets')->insert([
                'user_code' => $user->user_code,
                'OrdersTarget' => $defaultTarget,
                'AchievedOrdersTarget' => '0',
                'Deadline' => $endOfMonth,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('sales_targets')->insert([
                'user_code' => $user->user_code,
                'SalesTarget' => $defaultTarget,
                'AchievedSalesTarget' => '0',
                'Deadline' => $endOfMonth,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('visits_targets')->insert([
                'user_code' => $user->user_code,
                'VisitsTarget' => $defaultTarget,
                'AchievedVisitsTarget' => '0',
                'Deadline' => $endOfMonth,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->info('Default targets with end-of-month deadline assigned to users successfully.');
    }
}
