<?php

namespace App\Console;

use App\Schedules\CrystalCustomerSchedule;
use App\Schedules\MKOCustomerSchedule;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('reset:targets')->hourlyAt(1);

        $schedule->command('custom:logout-all-users')->dailyAt('00:00');

        $schedule->call(MKOCustomerSchedule::class)->dailyAt('17:55');
        $schedule->call(CrystalCustomerSchedule::class)->dailyAt('10:30');
        $schedule->command('assign:default-target')->monthlyOn(1, '00:00');
        $schedule->command('logout:all')
        ->dailyAt('00:00');
        $schedule->command('reset:targets')
        ->dailyAt('19:48');
        // $schedule->command('reset:targets')
        // ->monthlyOn(1, '00:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
    
}
