<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFavouriteStores extends Model
{
    protected $table='user_favourite_stores';
    protected $fillable=['user_id','store_id'];
	
	public function stores()
    {
        return $this->hasOne(\App\Stores::class,'id','store_id');
    }
}
