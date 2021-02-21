<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sliders extends Model
{
    protected $table='sliders';
    protected $fillable=['name','image','status','trash','created_by','updated_by'];
}
