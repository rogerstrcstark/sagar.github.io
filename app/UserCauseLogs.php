<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCauseLogs extends Model
{
    protected $table='user_cause_logs';
    protected $fillable=['user_id','cause_id'];
}
