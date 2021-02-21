<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreDealsAndSales extends Model
{
    protected $table='store_deals_and_sales';
    protected $fillable=['store_id','store_cat_id','name','slug','image','raised_up_to','shop_link','coupon_code','details','status','trash','created_by','updated_by'];
}
