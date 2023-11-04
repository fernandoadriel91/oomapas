<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valve extends Model
{
    protected $fillable = [
    'name', 'schedule', 'address'
    ];
}
