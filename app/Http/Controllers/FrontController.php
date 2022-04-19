<?php

namespace App\Http\Controllers;

use App\Models\CategorieWaricrowd;
use App\Models\StatistiqueFrequentation;
use App\Models\Waricrowd;
use App\Models\Parametre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;

class FrontController extends Controller
{
    
    
public function accueil(Request $request){
        $is_home=true;

//dd(route('espace_menbre.notification_paiement_tontine'));

        $date = date('m/Y');
        $stat = StatistiqueFrequentation::firstOrNew(['slug'=>$date]);
        $stat->slug = date('m/Y');
        $stat->mois_annee = date('m/Y');
        $nombre_actuel = $stat->visiteur;
        $nouveau_nombre = $nombre_actuel +1;
        $stat->visiteur = $nouveau_nombre;
        $stat->save();

        $parametre = Parametre::first();
        $pourcentage = $parametre->pourcentage_frais;
        return view('welcome',['is_home'=>$is_home,'frais_de_gestion'=>$pourcentage]);

    }

    public function decouvrir_projets(){
        $liste_categorie = CategorieWaricrowd::all();
        $liste_waricrowd = Waricrowd::where('etat','!=','attente')->where('etat','!=','annuler')->where('etat','!=','recaler')->orderBy('id','desc')->get();

        $mot_cle =null;$date_publication =null;$la_categorie = null;


        if( isset($_GET['id_categorie'])){
            $id_categorie = $_GET['id_categorie'];
            if($id_categorie=='0'){
                $liste_waricrowd = Waricrowd::where('etat','!=','attente')->where('etat','!=','annuler')->where('etat','!=','recaler')->orderBy('id','desc')->get();
            }
            elseif($id_categorie!=null && !empty($id_categorie)){
                $la_categorie = CategorieWaricrowd::find($id_categorie);
                $liste_waricrowd = $la_categorie->waricrowds_valider;
            }
        }
/*        if( isset($_GET['id_categorie']) && isset($_GET['mot_cle']) && isset($_GET['date_publication']) ){
            $id_categorie = $_GET['id_categorie'];
            $mot_cle = $_GET['mot_cle'];
            $date_publication = $_GET['date_publication'];

            $liste_waricrowd = [];

            if($id_categorie!=null && !empty($id_categorie)){
                $la_categorie = CategorieWaricrowd::find($id_categorie);
                $liste_waricrowd_cat = $la_categorie->waricrods_valider;
                $liste_waricrowd_cat = $liste_waricrowd_cat->toArray();
                $liste_waricrowd = array_merge($liste_waricrowd,$liste_waricrowd_cat);
                dd($liste_waricrowd);
            }


            if($mot_cle!=null && !empty($mot_cle)){
                $liste_waricrowd_cle = Waricrowd::
                where('etat','=','valider')
                    ->where('etat','=','terminer')
                    ->Where('titre','LIKE',"%$mot_cle%")->get();
                $liste_waricrowd = array_merge($liste_waricrowd,$liste_waricrowd_cle);
            }

            if($date_publication!=null && !empty($date_publication)){
                $liste_waricrowd_date = Waricrowd::
                    where('etat','=','valider')
                    ->where('etat','=','terminer')
                    ->Where('created_at','=',$date_publication)
                    ->get();
                $liste_waricrowd = array_merge($liste_waricrowd,$liste_waricrowd_date);
            }

        }*/



        return view('liste_waricrowd',compact('liste_waricrowd','liste_categorie','la_categorie','date_publication','mot_cle'));
    }

    public function details_projet($id_crowd){
        $le_crowd = Waricrowd::find($id_crowd);
        return view('details_projet',compact('le_crowd'));
    }

    public function comment_ca_marche(){
        $current=true; return view('comment_ca_marche',['is_comment_ca_marche'=>$current]);

    }
    
    public function comment_ca_marche_mobile(){
        $current=true; return view('comment_ca_marche_mobile');

    }
    
    public function apropos(){
        $current=true; return view('apropos',['is_apropos'=>$current]);

    }


    public function faq(){
        $current=true; return view('faq',['is_faq'=>$current]);

    }


    public function contact(){
        $current=true; return view('contact',['is_contact'=>$current]);

    }


    #=================================================== utilitaire
    private function setCookie(){
        $minutes = 1;
//        $response = new Response('Set Cookie');
//        $response->withCookie(cookie('name', 'a_visiter_waribana_ce_mois', $minutes));
        if(Cookie::queue('name', "a_visiter_waribana_ce_mois", 10)){
            dd(true);
        }else{
            dd(false);
        }
    }

    private function hasCookie(Request $request){
        $value = $request->cookie('"a_visiter_waribana_ce_mois"');
        if($value!=null){
            return true;
        }else{
            return false;
        }
    }

    private function getCookie(Request $request){
        $value = $request->cookie('"a_visiter_waribana_ce_mois"');
        return $value;
    }

}
