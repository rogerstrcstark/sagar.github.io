<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportEnquiry extends Model
{
    protected $table='support_enquiries';
    protected $fillable=['support_type','name','email_address','comments'];
}
