<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'email', 'password', 'first_name','last_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
    @param string|array $roles
    */
    //Relation
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function authorizedRole($roles)
    {
        if (is_array($roles)) {
             return $this->hasAnyRole($roles) ||   abort(401, 'This Action is unauthorized.');
        }
        return $this->hasRole($roles) ||   abort(401, 'This Action is unauthorized.');
    }

    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($roles)
    { 
        return null !== $this->roles()->where('name',$roles)->first();
    }
}
