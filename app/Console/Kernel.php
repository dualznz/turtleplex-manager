<?php

namespace App\Console;

use App\Jobs\OmbiUsersImporter;
use App\Jobs\PingHosts;
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
        /*
         * Dispatch jobs every 15 minutes
         */
        $schedule->call(function () {
           dispatch(new OmbiUsersImporter());
        })->everyFifteenMinutes();

        /*
         * Dispatch jobs every minute
         */
        $schedule->call(function () {
            dispatch(new PingHosts());
        })->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
