<?php

namespace App\Http\Middleware;

use App\Http\Controllers\MenbreController;
use Closure;
use Illuminate\Http\Request;

class MenbreConnecter
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
        if(session()->has(MenbreController::$cle_session)){
            return $next($request);
        }else{
            return redirect()->route('connexion_menbre');
        }
    }
}
