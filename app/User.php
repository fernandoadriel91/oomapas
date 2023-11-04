<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name', 'username', 'email', 'password', 'role_id', 'dependency_id', 'department_id', 'active','last_login', 'change_password',
        'password_expires', 'last_password_changed', 'timeout'
    ];

    protected $attributes = [
        'active' => 1,
        'change_password' => 1,
        'password_expires' => 1,
        'timeout' => 0
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }

    public function passwords()
    {
        return $this->hasMany('App\PasswordHistory')->orderBy('id', 'desc')->limit(4);
    }

    public function dependency()
    {
        return $this->belongsTo('App\Dependency', 'dependency_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }
}
