<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table='faqs';
    protected $fillable=['title','description','image','video_url','status','trash','created_by','updated_by','number_image'];
}
