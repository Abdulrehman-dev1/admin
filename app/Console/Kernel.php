<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\CheckAuctionStatusJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Simple test schedule:
        
        // Your actual job schedule:
			$schedule->job(new \App\Jobs\CheckAuctionStatusJob)
        ->everyMinute()
        ->withoutOverlapping()
        ->onOneServer();

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
