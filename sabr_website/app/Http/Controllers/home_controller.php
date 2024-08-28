<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\offer;

class home_controller extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }
    public function index(){
        $offers = offer::whereActive(1)->get();
        return view('welcome',compact("offers"));
    }
}
