<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImpactProducts extends Model
{
    protected $table='impact_products';
    protected $fillable=['store_id','name','slug','description','price','impact','shop_link','total_goals','achieved_goals','total_raised','video_url','logo','image','pros','cons','status','trash','is_verified','created_by','updated_by','store_cat_id','rating','imapct_image','imapct_video_url','is_featured','photos'];
	
	public function Stores()
    {
        return $this->belongsTo(\App\Stores::class,'store_id','id');
    }
	
	public function ProsAndCons()
    {
        
		return $this->hasMany(\App\ImpactProductProsAndCons::class,'impact_product_id','id');
    }
	
	public function StoreCategory()
    {
        return $this->belongsTo(\App\StoreCategory::class,'store_cat_id','id');
    }
	
	public function ImpactProductReviews()
    {
        return $this->hasOne(\App\ImpactProductReviews::class,'id','impact_product_id');
    }
	
	public function UserFavouriteImpactProducts()
    {
        return $this->belongsTo(\App\UserFavouriteImpactProducts::class,'user_favourite_impact_products','id');
    }
	
}
