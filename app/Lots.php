<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lots extends Model
{
	protected $table = "lots";
	protected $fillable = ['lot_name', 'description', 'category_id', 'start_price', 'images', 'owner_id', 'begin_auction', 'end_auction', 'disabled', 'disabled_date', 'disable_reason_id', 'fianl_price', 'pay_status_id', 'winner_id'];

	public function users()
	{
		return $this->belongsTo('App\Users', 'owner_id', 'id');
	}	
    
	public function category()
	{
		return $this->belongsTo('App\Categories', 'category_id', 'id');
	}	

	public function disabl()
	{
		return $this->belongsTo('App\Block_reasons', 'disable_reason_id', 'id');
	}    

	public function winner()
	{
		return $this->belongsTo('App\Users', 'winner_id', 'id');
	}

	public function pay_status()
	{
		return $this->belongsTo('App\Pay_status', 'pay_status_id', 'id');
	}	

	public function bets()
	{
		return $this->hasMany('App\Bets', 'lot_id', 'id');
	}
}
