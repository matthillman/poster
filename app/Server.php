<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
	protected $fillable = [ 'name', 'webhook_url' ];

	public function payouts() {
		return $this->hasMany('App\Payout');
	}
}
