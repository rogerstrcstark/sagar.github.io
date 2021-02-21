<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    protected $table='blogs';
    protected $fillable=['title','slug','description','image','status','trash','created_by','updated_by','video_url','blog_by','author_image'];
}
