<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{
    protected $fillable = [ 'password', 'user_id' ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
