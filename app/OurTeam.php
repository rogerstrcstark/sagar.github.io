<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    protected $table='our_teams';
    protected $fillable=['name','image','designation','fb_url','linkedin_url','instagram_url','status','trash','created_by','updated_by'];
}
