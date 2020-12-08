<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $fillable=['voucherno','orderdate','total','status','notes','user_id'];

   public function user($value='')
   {
   	 return $this->belongsTo('App\User');
   }
   public function items($value='')
   {
   	 return $this->belongsToMany('App\Item','orderdetail')
   	 			->withPivot('qty')
   	 			->withTimestamps();
   }
}
