<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    protected $table='store_categories';
    protected $fillable=['name','slug','image','status','trash','created_by','updated_by','icon'];
	
	public function stores()
    {
        return $this->hasMany(\App\Stores::class,'store_cat_id','id');
    }
	
	public function ImpactProducts()
    {
        return $this->hasMany(\App\ImpactProducts::class,'store_cat_id','id');
    }
	
	public function ImpactProductReviews()
    {
        return $this->hasOne(\App\ImpactProductReviews::class,'id','store_cat_id');
    }
}
