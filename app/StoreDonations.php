<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreDonations extends Model
{
    protected $table='store_donations';
    protected $fillable=['store_id','amount'];
	
	public function stores()
    {
        return $this->hasMany(\App\Stores::class,'id','store_id');
    }
}
