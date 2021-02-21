<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table='role_user';
	
	protected $fillable = [
        'role_id', 'user_id'
    ];
	
	public function User()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function Role()
	{
		return $this->hasOne(\App\Role::class, 'id', 'role_id');
	}
}
