<?php

namespace App;

use Illuminate\Database\Eloquent\Model;;

class Permission_Role extends Model
{
    protected $fillable = [
        'permission_id', 'role_id','c','r','u','d', 'admin'
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function permission()
    {
        return $this->belongsTo('App\Permission');
    }
}