<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\role;

class role_controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show(){
        return view('roles.show');
    }
    public static function all(){
        return role::all();
    }
}
