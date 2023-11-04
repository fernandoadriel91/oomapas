<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [ 'reference_table', 'reference_id', 'user_id', 'body', 'reference_field', 'old_value' ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
