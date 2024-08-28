<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
    public function User()
    {
        return $this->belongsToMany('App\User', 'users_banks');
    }
    public function account()
    {
        return $this->belongsTo('App\account');
    }
}
