<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    protected $table='stores';
    protected $fillable=['store_cat_id','name','slug','description','image','logo','video_url','status','trash','created_by','updated_by','medium','shop_link','total_raised','raised_up_to','important_details','package_name'];
	
	public function StoreCategory()
    {
        return $this->belongsTo(\App\StoreCategory::class,'store_cat_id','id');
    }
	
	public function donations()
    {
        return $this->hasMany(\App\DonationRates::class,'store_id','id');
    }
	
	public function impactproducts()
    {
        return $this->hasMany(\App\ImpactProducts::class,'id','store_id');
    }
	
	public function UserFavouriteStores()
    {
        return $this->belongsTo(\App\UserFavouriteStores::class,'store_id','id');
    }
	
	public function StoreDonations()
    {
        return $this->belongsTo(\App\StoreDonations::class,'store_id','id');
    }
}
