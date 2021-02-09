<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roles()
    {
    	return $this
    	->belongsToMany('App\Role')
    	->withTimestamps();
    }
    public function authorizeRoles($roles)
    {
    	abort_unless($this->hasAnyRole($roles), 401);
    	return true;
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
    public function getRollStr(){
    	$nameRole=["Root","Administrator","user","invited"];
    	$role =["super-admin","admin","user","other"];
    	for($i =0; $i<sizeof($role); $i++){
    		if($this->hasAnyRole($role[$i]))
    			return $nameRole[$i];
    	}
    	return "other";
    }
}
