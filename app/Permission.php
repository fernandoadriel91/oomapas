<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'title', 'icon', 'route','menu','priority', 'parent'
    ];

    protected $attributes = [
        'icon' => '',
        'priority' => -1,
        'parent' => -1,
    ];

    public function childrens()
    {
        return $this->hasMany('App\Permission', 'parent', 'id');
    }

    public function childs()
    {
        return $this->childrens()->with('childs')->orderBy('priority', 'ASC');
    }

    public function roles()
    {
        return $this->belongsToMany("App\Role", 'permission__roles')->withPivot('C', 'R', 'U', 'D', 'admin');
    }
}
