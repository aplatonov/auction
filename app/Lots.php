<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lots extends Model
{
	protected $table = "lots";
	protected $fillable = ['lot_name', 'description', 'category_id', 'start_price', 'images', 'owner_id', 'begin_auction', 'end_auction', 'disabled', 'disabled_date', 'disable_reason_id', 'fianl_price', 'pay_status_id', 'winner_id'];
    
}
