<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CauseCategory extends Model
{
    protected $table='cause_categories';
    protected $fillable=['name','slug','description','image','status','trash','created_by','updated_by','icon','thumbnail'];
	
	public function Charity()
    {
        return $this->hasMany(\App\Charity::class,'id','cause_cat_id');
    }
}
