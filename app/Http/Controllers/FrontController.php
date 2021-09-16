<?php

namespace App\Http\Controllers;

use App\Models\Waricrowd;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function accueil(){
        $is_home=true;
        return view('welcome',['is_home'=>$is_home]);
    }

    public function decouvrir_projets(){
        $liste_waricrowd = Waricrowd::where('etat','!=','attente')->where('etat','!=','annuler')->where('etat','!=','recaler')->get();
//        dd($liste_waricrowd);
        return view('liste_waricrowd',compact('liste_waricrowd'));
    }

    public function details_projet($id_crowd){
        $le_crowd = Waricrowd::find($id_crowd);
        return view('details_projet',compact('le_crowd'));
    }

    public function comment_ca_marche(){
        $current=true; return view('comment_ca_marche',['is_comment_ca_marche'=>$current]);

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


}
