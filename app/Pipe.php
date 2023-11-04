<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pipe extends Model
{
    protected $fillable = [
        'name', 'telephone', 'address', 'contract', 'folio', 'comment', 'active', 'photo'
    ];

    protected $attributes = [
        'active' => 0
    ];
}
