<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class ResetTargets extends Command
{
    protected $signature = 'reset:targets';

    protected $description = 'Reset OrdersTarget for every user to 20000 at the beginning of each month.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the current month and year
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');

        // Update OrdersTarget for users who haven't set a target for the current month
        User::whereDoesntHave('TargetsOrder', function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('Deadline', $currentMonth)->whereYear('Deadline', $currentYear);
        })->update(['OrdersTarget' => 20000]);

        $this->info('OrdersTarget reset for users without targets for ' . Carbon::now()->format('F Y') . '.');
    }
}
