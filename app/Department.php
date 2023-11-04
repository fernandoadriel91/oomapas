<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'id', 'name', 'dependency_id', 'active'
    ];

    public $incrementing = false;

    public function dependency()
    {
        return $this->belongsTo('App\Dependency');
    }
}
