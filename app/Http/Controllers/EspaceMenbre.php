<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EspaceMenbre extends Controller
{
    public function accueil(){
        return view('espace_menbre/index');
    }

    public function deconnexion(){
        session()->pull(MenbreController::$cle_session);
        return redirect()->route('connexion_menbre');
    }
}
