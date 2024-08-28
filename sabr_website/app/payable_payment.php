<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payable_payment extends Model
{
    public function contract(){
        return $this->belongsTo('App\contract');
    }
}
