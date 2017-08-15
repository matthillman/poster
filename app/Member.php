<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DateTime;

class Member extends Model
{
	protected $fillable = [ 'name', 'starting_rank' ];

	protected $appends = ['todays_order'];

	public function payout() {
		return $this->belongsTo('App\Payout', 'payout_id');
	}

	public function getTodaysOrderAttribute() {
		$origin = $this->payout->order_effective_at;
		$startDate = new DateTime($origin);
		$today = new DateTime;
		$diff = $today->diff($startDate);
		if ($diff->h > 0 || $diff->i > 0 || $diff->s > 0) {
			$today->modify("+1 day");
		}
		$today->setTime((int)$startDate->format('H'), (int)$startDate->format('M'));
		$days = $today->diff($startDate)->d;

		$order = range($this->payout->members->count(), 1);
		$startIndex = array_search($this->starting_rank, $order);
		$endIndex = ($startIndex + $days) % count($order);

		return $order[$endIndex];
	}
}
