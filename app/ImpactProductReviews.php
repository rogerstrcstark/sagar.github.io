<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImpactProductReviews extends Model
{
    protected $table='impact_product_reviews';
    protected $fillable=['impact_product_id','store_cat_id','name','image','youtube_url','status','trash','created_by','updated_by'];
	
	public function StoreCategory()
    {
        return $this->belongsTo(\App\StoreCategory::class,'store_cat_id','id');
    }
	
	public function ImpactProduct()
    {
        return $this->belongsTo(\App\ImpactProducts::class,'impact_product_id','id');
    }
}
