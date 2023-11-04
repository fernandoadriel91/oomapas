<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependency extends Model
{
    protected $fillable = [
        'id', 'name', 'active'
    ];

    public $incrementing = false;

    public function departments()
    {
        return $this->hasMany('App\Deparments');
    }
}