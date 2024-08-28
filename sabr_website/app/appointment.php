<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function apartment(){
        return $this->belongsTo('App\apartment');
    }
}
