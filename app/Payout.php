<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
	protected $fillable = [ 'name', 'blurb', 'order_effective_at' ];

	public function members() {
		return $this->hasMany('App\Member');
	}

	public function webhook() {
		return $this->belongsTo('App\Server', 'server_id');
	}
}
