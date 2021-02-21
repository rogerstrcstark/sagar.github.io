<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDonations extends Model
{
    protected $table='user_donations';
    protected $fillable=['user_id','cause_id','amount','store_name'];
	
	public function user()
    {
        return $this->hasMany(\App\User::class,'id','user_id');
    }
}
