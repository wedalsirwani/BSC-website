<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reject_reason extends Model
{
    public function transaction(){
        return $this->belongsTo("App\transaction");
    }
}
