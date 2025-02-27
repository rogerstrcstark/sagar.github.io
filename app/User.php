<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','contact_number','gender','dob','profile_picture','cause_id','status','trash','username','provider','provider_id','device_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function roles()
	{
	  return $this->belongsToMany('App\Role')->withTimestamps();
	}
	
	public function authorizeRoles($roles)
	{
	  if ($this->hasAnyRole($roles)) {
		return true;
	  }
	  abort(401, 'This action is unauthorized.');
	}
	public function hasAnyRole($roles)
	{
	  if (is_array($roles)) {
		foreach ($roles as $role) {
		  if ($this->hasRole($role)) {
			return true;
		  }
		}
	  } else {
		if ($this->hasRole($roles)) {
		  return true;
		}
	  }
	  return false;
	}
	public function hasRole($role)
	{
	  if ($this->roles()->where('name', $role)->first()) {
		return true;
	  }
	  return false;
	}
	
	public function UserRole(){
       return $this->hasOne(\App\UserRole::class, 'user_id','id');
    }
	
	public function UserDonations()
    {
        return $this->belongsTo(\App\UserDonations::class,'user_id','id');
    }
}
