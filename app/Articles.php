<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $table = "articles";
	protected $fillable = ['descr', 'short_descr'];
}
