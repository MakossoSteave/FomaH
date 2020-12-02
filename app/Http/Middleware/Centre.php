<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Centre
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        //role de l'Admin = 1
        if(Auth::user()->role==1){
          return redirect()->route('admin');
        }
        //role du formateur =2
        if(Auth::user()->role==2){
           return redirect()->route('formateur');
        }
        //role du stagiaire =3
        if(Auth::user()->role==3){
           return redirect()->route('stagiaire');
        }
        //role du centre = 4
        if(Auth::user()->role==4){
            return $next($request);
        }
    }
}
