<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leak extends Model
{
    protected $fillable = [
        'address', 'street', 'comment', 'active', 'photo'
    ];

    protected $attributes = [
        'active' => 0
    ];
}
