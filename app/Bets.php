<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bets extends Model
{
	protected $table = "bets";
	protected $fillable = ['lot_id', 'user_id', 'bet_price', 'is_final'];
}
