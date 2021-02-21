<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImpactProductProsAndCons extends Model
{
    protected $table='impact_products_pros_and_cons';
    protected $fillable=['impact_product_id','type','title','status','trash','created_by','updated_by'];
	
	public function impactproducts()
    {
		return $this->belongsTo(\App\ImpactProducts::class,'impact_product_id','id'); 
    }
}
