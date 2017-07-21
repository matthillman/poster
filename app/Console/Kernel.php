<?php

namespace App\Console;

use DateTime;
use DateInterval;

use App\User;
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
        Commands\PostPayoutOrder::class,
        Commands\RunHourly::class,
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
			$d->sub(new DateInterval('PT1H'));
			$schedule->command(Commands\PostPayoutOrder::class, [$payout->id])
				->dailyAt($d->format("G:i"))
				->emailOutputTo(User::find(1)->email);
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
