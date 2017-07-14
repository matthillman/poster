<?php

namespace App\Console;

use DateTime;
use App\Payout;
use App\Console\Commands\PostPayoutOrder;
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
        Commands\PostPayoutOrder::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        Payout::all()->each(function($payout) use ($schedule) {
			$d = new DateTime($payout->order_effective_at);
			$d->sub(new DateInterval('PT1H1M'));
			$schedule->command(PostPayoutCommand::class, [$payout->id])->dailyAt($d->format("G:i"));
		});
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
