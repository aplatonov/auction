<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block_reasons extends Model
{
    protected $fillable = ['block_descr'];

	public function lots()
	{
		return $this->hasMany('App\Lots', 'disable_reason_id', 'id');
	}	      
}
