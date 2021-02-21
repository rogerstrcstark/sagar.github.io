<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreEnquiry extends Model
{
    protected $table='store_enquiries';
    protected $fillable=['email_address','purchase_date','store_id'];
}
