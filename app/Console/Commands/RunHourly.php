<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Cron\CronExpression;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

class RunHourly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:run-hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all scheduled events that were due at the most recent :00.';

    /**
     * The schedule instance.
     *
     * @var \Illuminate\Console\Scheduling\Schedule
     */
    protected $schedule;

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $eventsRan = false;

		$cutoff = Carbon::now();
		$cutoff = $cutoff->minute($cutoff->minute < 30 ? 0 : 30)->second(0)->timezone('UTC');
		$this->line('<info>Running all events due at:<info> ' . $cutoff->toDateTimeString());

		foreach ($this->schedule->events() as $event) {
			if (!CronExpression::factory($event->expression)->isDue($cutoff->toDateTimeString())) {
				continue;
			}

            $this->line('<info>Running scheduled command:</info> '.$event->getSummaryForDisplay());

            $event->run($this->laravel);

            $eventsRan = true;
        }

        if (!$eventsRan) {
            $this->info('No scheduled commands are ready to run.');
        }
    }
}
