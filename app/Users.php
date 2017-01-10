<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
	public function bets()
	{
		return $this->hasMany('App\Bets', 'user_id', 'id');
	}
	
	public function lots()
	{
		return $this->hasMany('App\Lots', 'owner_id', 'id');
	}

	public function winner()
	{
		return $this->hasMany('App\Lots', 'winner_id', 'id');
	}		
}
