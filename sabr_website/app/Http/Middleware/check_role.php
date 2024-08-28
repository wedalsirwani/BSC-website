<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use URL;
use Illuminate\Support\Facades\Redirect;

class check_role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->User()===null){
            return Redirect::to('/login');
        }
        $actions =$request->route()->getAction();
        $roles=isset($actions['roles']) ? $actions['roles'] : null;
        if($request->User()->hasAnyRole($roles) || !$roles){
            return $next($request);
        }
        return Redirect::to('/');
    }
}
