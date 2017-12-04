<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use StudentAffairsUwm\Shibboleth\Entitlement;

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

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function isAdmin() : bool
    {
        return Entitlement::has(config('shibboleth.admin'));
    }

    public function getUsername() : string
    {
        return strstr($this->attributes['email'], '@', true);
    }
}
