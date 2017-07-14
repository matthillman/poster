<?php

namespace App\Console\Commands;

use DateTime;
use App\Payout;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class PostPayoutOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payout:post {payout}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the payout notification for the given payout';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$payout = Payout::find($this->argument('payout'));
		$this->info($payout->name);
		$message = $payout->blurb . "\n";
		foreach ($payout->members->sortBy('todays_order') as $member) {
			$message .= "  {$member->todays_order}. {$member->name}\n";
		}
		$client = new Client;
		$response = $client->post($payout->webhook->webhook_url, [
			'json' => ['content' => $message]
		]);
    }
}
