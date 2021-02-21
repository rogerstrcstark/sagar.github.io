<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    protected $table='home_page';
    protected $fillable=['type','title','phone_title','description','phone_description','sub_description','phone_sub_description','featured_image','phone_featured_image','section_heading','button_text'];
}
