<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maintanance_request extends Model
{
    protected $table="requests";
    protected $fillable = ["request_status"];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function apartment(){
        return $this->belongsTo('App\apartment');
    }
    use HasFactory;
}
