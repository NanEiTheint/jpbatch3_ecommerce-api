<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
	protected $fillable = ['name', 'photo'];

	public function item($value='')
	{
		return $this->hasMany("App\Item");
	}
}
