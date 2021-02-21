<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaigner extends Model
{
    protected $table='campaigners';
    protected $fillable=['name','image','location','ngo','is_verified','status','trash','created_by','updated_by'];
	
	public function Charity()
    {
        return $this->hasOne(\App\Charity::class,'id','campanigner_id');
    }
}
