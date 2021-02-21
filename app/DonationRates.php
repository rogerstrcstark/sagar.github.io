<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationRates extends Model
{
    protected $table='donation_rates';
    protected $fillable=['store_id','title','donation_rate','status','trash','created_by','updated_by'];
	
	public function Stores()
    {
        return $this->belongsTo(\App\Stores::class,'store_id','id');
    }
}
