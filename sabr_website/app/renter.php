<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class renter extends Model
{
    public function contracts(){
        return $this->hasMany('App\contract');
    }
    public function apartments(){
        return $this->hasMany('App\apartment');
    }
}
