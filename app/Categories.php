<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = "categories";
    public $fillable = ['name_cat', 'parent_id'];

    public function childs() {

        return $this->hasMany('App\Categories','parent_id','id') ;
    }
	
	public function lots()
	{
		return $this->hasMany('App\Lots', 'category_id', 'id');
	}	    
}
