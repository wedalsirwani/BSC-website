<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    public function User(){
        return $this->belongsTo('App\User');
    }
    public function contract(){
        return $this->belongsTo('App\contract');
    }
}
