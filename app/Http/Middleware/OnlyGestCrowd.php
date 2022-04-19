<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyGestCrowd
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
        
        if(auth()->user()->role != 'super_admin' && auth()->user()->role != 'administrateur_general' && auth()->user()->role != 'gestionnaire_de_waricrowd' ){
            return redirect()->route('dashboard');
        }
        return $next($request);    
    }
}
