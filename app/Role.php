<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'state', 'description', 'active'
    ];

    protected $attributes = [
        'active' => 1
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'permission__roles')->withPivot('C', 'R', 'U', 'D', 'admin');
    }
}
