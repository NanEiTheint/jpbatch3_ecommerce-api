<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['name', 'photo'];

  // relationship methods
	public function subcategories($value='')
	{
		return $this->hasMany('App\Subcategory');
	}
}
