<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $table='beneficiaries';
    protected $fillable=['name','image','location','ngo','is_verified','status','trash','created_by','updated_by'];
	
	public function Charity()
    {
        return $this->hasOne(\App\Charity::class,'id','beneficiary_id');
    }
}
