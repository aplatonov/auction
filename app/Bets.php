<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bets extends Model
{
	protected $table = "bets";
	protected $fillable = ['lot_id', 'user_id', 'bet_price', 'is_final'];

	public function users()
	{
		return $this->belongsTo('App\Users', 'user_id', 'id');
	}

	public function lots()
	{
		return $this->belongsTo('App\Lots', 'lot_id', 'id');	
	}
}
