<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\bank;

class bank_controller extends Controller
{
    public static function all(){
        return bank::all();
    }
}
