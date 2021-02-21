<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyReports extends Model
{
    protected $table='monthly_reports';
    protected $fillable=['title','from_date','end_date','pdf_file','image','status','trash','created_by','updated_by'];
}
