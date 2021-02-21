<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    protected $table='banners';
    protected $fillable=['title','image','link','status','trash','created_by','updated_by'];
}
