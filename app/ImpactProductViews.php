<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImpactProductViews extends Model
{
    protected $table='impact_product_views';
    protected $fillable=['impact_product_id','ip_address','view_count'];
}
