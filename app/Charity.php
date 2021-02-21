<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charity extends Model
{
    protected $table='charities';
    protected $fillable=['cause_cat_id','campanigner_id','beneficiary_id','name','slug','description','shop_link','end_date','total_goals','achieved_goals','total_supporters','logo','image','photos','video_url','is_verified','is_completed','status','trash','created_by','updated_by','thank_you_card_image','thank_you_note'];
	
	public function CauseCategory()
    {
        return $this->belongsTo(\App\CauseCategory::class,'cause_cat_id','id');
    }
	
	public function Campaigner()
    {
        return $this->belongsTo(\App\Campaigner::class,'campanigner_id','id');
    }
	
	public function Beneficiary()
    {
        return $this->belongsTo(\App\Beneficiary::class,'beneficiary_id','id');
    }
}
