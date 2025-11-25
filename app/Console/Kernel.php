<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Auction Status Check - Run every minute
        $schedule->command('auction:check-status')
            ->everyMinute()
            ->withoutOverlapping()
            ->onOneServer()
            ->appendOutputTo(storage_path('logs/auction-status.log'));

        // Auto Bidder - Run every 12 hours
        $schedule->command('auto:bid')
            ->twiceDaily(0, 12)
            ->withoutOverlapping()
            ->onOneServer()
            ->appendOutputTo(storage_path('logs/auto-bid.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
