<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class benefit extends Model
{
    use HasFactory;
    public function User(){
        return $this->belongsTo("App\User");
    }
}
