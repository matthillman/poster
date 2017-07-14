<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DateTime;

class Member extends Model
{
	protected $fillable = [ 'name', 'starting_rank' ];

	protected $appends = ['todays_order'];

	public function payout() {
		return $this->belongsTo('App\Payout');
	}

	public function getTodaysOrderAttribute() {
		$origin = $this->payout->order_effective_at;
		$startDate = new DateTime;
		$startDate->setTimestamp($origin->getTimestamp());
		$today = new DateTime;
		$today->setTime((int)$startDate->format('H'), (int)$startDate->format('M'));
		$days = $today->diff($startDate)->d;

		$order = [3, 2, 1];
		$startIndex = array_search($this->starting_rank, $order);
		$endIndex = ($startIndex + $days) % 3;

		return $order[$endIndex];
	}
}
