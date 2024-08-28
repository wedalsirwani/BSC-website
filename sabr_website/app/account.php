<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class account extends Model
{
    public function bank()
    {
        return $this->hasMany('App\bank');
    }
    public function transaction(){
        return $this->hasMany('App\transaction');
    }
    public function User(){
        return $this->belongsTo("App\User");
    }
}
