<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    public function User()
    {
        return $this->belongsToMany('App\User', 'users_roles');
    }
}
