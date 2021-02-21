<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFavouriteImpactProducts extends Model
{
    protected $table='user_favourite_impact_products';
    protected $fillable=['user_id','impact_product_id'];
	
	public function ImpactProducts()
    {
        return $this->hasOne(\App\ImpactProducts::class,'id','impact_product_id');
    }
}
