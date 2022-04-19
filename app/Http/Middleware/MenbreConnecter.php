<?php

namespace App\Http\Middleware;

use App\Http\Controllers\MenbreController;
use App\Models\Menbre;
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
            $la_session =session(MenbreController::$cle_session);
//            dd($la_session);
            $id_menbre_connecter = $la_session['id'];
            $le_menbre = Menbre::find($id_menbre_connecter);

            if($le_menbre->etat=='actif' && $le_menbre->devise!=null){
                return $next($request);
            }elseif($le_menbre->etat=='suspendu'){
                $notification =  "<div class='alert alert-danger'> Votre compte a été SUSPENDU, Motif : $le_menbre->motif_intervention_admin </div>";
                return  redirect()->route('connexion_menbre')->with('notification',$notification);
            }elseif($le_menbre->etat=='banni'){
                $notification =  "<div class='alert alert-danger'> Votre compte a été BANNI, Motif : $le_menbre->motif_intervention_admin </div>";
                return  redirect()->route('connexion_menbre')->with('notification',$notification);
            }elseif($le_menbre->etat=='attente'){
                return  redirect()->route('espace_menbre.confirmer_compte_menbre');
            }elseif($le_menbre->devise==null){
                return  redirect()->route('espace_menbre.confirmer_compte_menbre');
            }
            return $next($request);
        }else{
            return redirect()->route('connexion_menbre');
        }
    }
}
