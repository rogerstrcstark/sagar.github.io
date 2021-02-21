<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{
     protected $table='testimonials';
     protected $fillable=['name','occupation','comments','image','status','trash','created_by','updated_by'];
}
