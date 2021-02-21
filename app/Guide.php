<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $table='guides';
    protected $fillable=['name','image','description','status','trash','created_by','updated_by'];
}
