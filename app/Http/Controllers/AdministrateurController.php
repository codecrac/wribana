<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Menbre;
use App\Models\Tontine;
use App\Models\Transaction;
use App\Models\Waricrowd;
use Illuminate\Http\Request;

class AdministrateurController extends Controller
{
//    ===============================TONTINES
    public function les_tontines(){
        $les_tontines = Tontine::all();
        return view("administrateur/tontines/liste",compact('les_tontines'));
    }
    public function details_tontine($id_tontine){
        $la_tontine = Tontine::find($id_tontine);

        $liste_ayant_cotiser = [];
        if($la_tontine->caisse!=null){
            //Liste des transaction pour le tour courant
            $liste_ayant_cotiser = Transaction::where('id_tontine','=',$id_tontine)
                ->where('id_menbre_qui_prend','=',$la_tontine->caisse->menbre_qui_prend->id)->get();
        }

        $invitations_envoyees = Invitation::where('id_tontine','=',$id_tontine)->get();
        $transactions_de_la_tontine = $la_tontine->transactions;
        return view("administrateur/tontines/details_tontine",compact('la_tontine','invitations_envoyees','liste_ayant_cotiser','transactions_de_la_tontine'));
    }

    public function changer_etat_tontine(Request $request,$id_tontine){

        $donnees_formulaire = $request->all();
        $nouvel_etat = $donnees_formulaire['nouvel_etat'];
        $motif_intervention = $donnees_formulaire['motif_intervention'];

//        dd($donnees_formulaire);

        $la_tontine = Tontine::find($id_tontine);
        $la_tontine->etat = $nouvel_etat;
        $la_tontine->motif_intervention_admin = $motif_intervention;
        if($la_tontine->save()){
            $notification ="<div class='alert alert-success text-center'> Operation bien éffectuée </div>";
        }else{
            $notification ="<div class='alert alert-danger text-center'> Quelque chose s'est mal passé </div>";
        }

        return redirect()->back()->with('notification',$notification);
    }

//    ===============================WARICROWD

    public function les_waricrowds($filtre=null){
        if($filtre!=null){
            $liste_waricrowd = Waricrowd::where('etat','=',$filtre)->get();
        }else{
            $liste_waricrowd = Waricrowd::all();
        }
        return view("administrateur/waricrowds/liste",compact('liste_waricrowd'));
    }
    public function details_waricrowd($id_crowd){
        $le_crowd = Waricrowd::find($id_crowd);

        $transactions_du_waricrowd = $le_crowd->transactions;
        return view("administrateur/waricrowds/details_waricrowd",compact('le_crowd','transactions_du_waricrowd'));
    }

    public function changer_etat_crowd(Request $request,$id_crowd){

        $donnees_formulaire = $request->all();
        $nouvel_etat = $donnees_formulaire['nouvel_etat'];
        $motif_intervention = $donnees_formulaire['motif_intervention'];

//        dd($donnees_formulaire);

        $le_crowd = Waricrowd::find($id_crowd);
        $le_crowd->etat = $nouvel_etat;
        $le_crowd->motif_intervention_admin = $motif_intervention;
        if($le_crowd->save()){
            $notification ="<div class='alert alert-success text-center'> Operation bien éffectuée </div>";
        }else{
            $notification ="<div class='alert alert-danger text-center'> Quelque chose s'est mal passé </div>";
        }

        return redirect()->back()->with('notification',$notification);
    }

    //    ===============================GESTION MENBRES EXTERNES
    public function liste_menbres_inscrits($filtre=null){
        if($filtre!=null){
            $liste_menbres_inscrits = Waricrowd::where('etat','=',$filtre)->get();
        }else{
            $liste_menbres_inscrits = Menbre::all();
        }
        return view('administrateur/liste_menbres_inscrits',compact('liste_menbres_inscrits'));
    }

    public function suspendre_menbre(Request $request,$id_menbre){

        $donnees_formulaire = $request->all();
        $nouvel_etat = $donnees_formulaire['nouvel_etat'];
        $motif_intervention = $donnees_formulaire['motif_intervention'];

//        dd($donnees_formulaire);

        $le_menbre = Menbre::find($id_menbre);
        $le_menbre->etat = $nouvel_etat;
        $le_menbre->motif_intervention_admin = $motif_intervention;
        if($le_menbre->save()){
            $notification ="<div class='alert alert-success text-center'> Operation bien éffectuée </div>";
        }else{
            $notification ="<div class='alert alert-danger text-center'> Quelque chose s'est mal passé </div>";
        }

        return redirect()->back()->with('notification',$notification);
    }
}
