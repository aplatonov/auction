<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pay_status extends Model
{
    protected $table = "pay_status";
    protected $fillable = ['pay_descr'];

	public function lots()
	{
		return $this->hasMany('App\Lots', 'pay_status_id', 'id');
	}		    
}
