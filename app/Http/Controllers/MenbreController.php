<?php

namespace App\Http\Controllers;

use App\Models\CompteMenbre;
use App\Models\Menbre;
use Illuminate\Http\Request;

class MenbreController extends Controller
{

    public static $cle_session = "menbre_waribana_connecter";


    public function connexion_menbre(){
        return view('connexion_menbre');

    }
    public function inscription_menbre(){
        return view('inscription_menbre');

    }

    public function enregistrer_un_menbre(Request $request){
        $couleur = "danger";


        $donnee_formulaire = $request->all();
//        dd($donnee_formulaire);
        $nom_complet = $donnee_formulaire['nom_complet'];
        $telephone = $donnee_formulaire['telephone'];
        $email = $donnee_formulaire['email'];
        $mot_de_passe = $donnee_formulaire['mot_de_passe'];
        $confirmer_mot_de_passe = $donnee_formulaire['confirmer_mot_de_passe'];

//        ---------------Verifie existence des identifiant
        if($email !=null){
            $route_connexion = route('connexion_menbre');
            $email_existe_deja = $this->checkExistenceEmail($email);
            if($email_existe_deja){
                $message = "Cette adresse email est déja utilisée. <a href='$route_connexion' >connectez-vous</a>";
                $notification = "<div class='alert alert-$couleur'> $message  </div>";
                return redirect()->route('inscription_menbre')->with('notification',$notification);
            }
        }
        $telephone_existe_deja = $this->checkExistenceNumero($telephone);
        if($telephone_existe_deja){
            $message = "Ce numero de telephone a déja utilisé. <a href='$route_connexion' >connectez-vous</a>";
            $notification = "<div class='alert alert-$couleur'> $message  </div>";
            return redirect()->route('inscription_menbre')->with('notification',$notification);
        }

//        ---------------Verifie mot de passe et enregistrement

        if($mot_de_passe != $confirmer_mot_de_passe){
            $message = "Echec inscription, Les mots de passe ne sont pas identiques.";
        }else{
            $mot_de_passe_cacher = md5($confirmer_mot_de_passe);

            $le_menbre = new Menbre();
            $le_menbre->nom_complet = $nom_complet;
            $le_menbre->telephone = $telephone;
            $le_menbre->email = $email;
            $le_menbre->mot_de_passe = $mot_de_passe_cacher;

            if($le_menbre->save()){

                $le_compte = CompteMenbre::findOrNew($le_menbre->id);
                $le_compte->id_menbre = $le_menbre->id;
                $le_compte->solde = 0;
                $le_compte->save();

                $couleur = "success";
                $message = "Inscription éffectuée, connectez-vous";
                $notification = "<div class='alert alert-$couleur'> $message  </div>";
                return redirect()->route('connexion_menbre')->with('notification',$notification);
            }
        }

        $notification = "<div class='alert alert-$couleur'> $message  </div>";
        return redirect()->route('inscription_menbre')->with('notification',$notification);


    }

    public function connexion(Request $request){
        $donnees_formulaire = $request->all();
        $identifiant = $donnees_formulaire['identifiant'];
        $mot_de_passe = $donnees_formulaire['mot_de_passe'];

        $mot_de_passe_caher = md5($mot_de_passe);
//        $le_menbre = Menbre::where('email','=',$identifiant)->orWhere('telephone','=',$identifiant)->first();
        $le_menbre = Menbre::where('email','=',$identifiant)->orWhere('telephone','=',$identifiant)->where('mot_de_passe','=',$mot_de_passe_caher)->first();

        if($le_menbre !=null){
            $this->creer_session_menbre($le_menbre);
            return redirect()->route('espace_menbre.accueil');
        }else{
            $couleur = "danger";
            $message = "Identifiant ou Mot de passe Incorrect";
            $notification = "<div class='alert alert-$couleur'> $message  </div>";
            return redirect()->route('connexion_menbre')->with('notification',$notification);
            return redirect()->route('connexion_menbre');
        }


    }










    #========================Utilitaire============================#
    private function checkExistenceEmail($email){
        $menbre_existant = Menbre::where('email','=',$email)->first();
        if($menbre_existant != null){
            return true;
        }else{
            return false;
        }
    }

    private function checkExistenceNumero($numero){
        $menbre_existant = Menbre::where('telephone','=',$numero)->first();
        if($menbre_existant != null){
            return true;
        }else{
            return false;
        }
    }

    private function creer_session_menbre($le_menbre){
        $id_menbre = $le_menbre->id;
        $nom_complet = $le_menbre->nom_complet;
        session()->put(MenbreController::$cle_session,['id'=>$id_menbre,'nom_complet'=>$nom_complet]);
    }

}
