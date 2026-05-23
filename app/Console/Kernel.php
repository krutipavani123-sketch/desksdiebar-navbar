<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     */
    protected $commands = [
        // Register your custom commands here
        \App\Console\Commands\checkslastatus::class,
    ];

    /**
     * Define the application's command schedule.
     */
    // protected function schedule(Schedule $schedule)
    // {
    //     // Schedule the SLA check command to run every minute
    //     $schedule->command('app:checkslastatus')->everyMinute();
    // }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }



    //auto run 
    // protected function schedule(Schedule $schedule): void
    // {
    //     $schedule->command('app:checkslastatus')->everyMinute();
    // }
}
