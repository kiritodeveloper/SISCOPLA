<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AdminMiddleware
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
        if(Auth::user()->rol!="Administrador")
        {
            Auth::logout();
            Session::flash("noticie",'Los permisos de acceso fueron violados');
            return redirect('/');
        }
        return $next($request);
    }
}
