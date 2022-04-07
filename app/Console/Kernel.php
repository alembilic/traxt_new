<?php

namespace App\Console;

use App\Console\Commands\ParseBackLinks;
use App\Console\Commands\RenewSubscription;
use App\Console\Commands\UpdateCurrency;
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
        ParseBackLinks::class,
        RenewSubscription::class,
        UpdateCurrency::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // uncomment on production
//        $schedule->command('backlinks:parse')->daily();
//        $schedule->command('subscriptions:renew')->daily();
        $schedule->command('currency:update')->onOneServer()->dailyAt('09:30');
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
