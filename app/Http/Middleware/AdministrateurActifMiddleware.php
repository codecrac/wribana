<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class AdministrateurActifMiddleware
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
        // dd(auth()->user()->etat);
        if(auth()->user()->etat != 'actif'){
            return redirect()->route('admin.deconnexion');
        }
        return $next($request);
    }
}
