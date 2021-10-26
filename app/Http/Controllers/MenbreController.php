<?php

namespace App\Http\Controllers;

use App\Models\CompteMenbre;
use App\Models\Devise;
use App\Models\Menbre;
use App\Models\SmsContenuNotification;
use Illuminate\Http\Request;

class MenbreController extends Controller
{

    public static $cle_session = "menbre_waribana_connecter";


    public function connexion_menbre()
    {
        return view('connexion_menbre');
    }
    public function reinitialiser_mot_de_passe()
    {
        return view('reinitialiser_mot_de_passe');

    }
    public function post_reinitialiser_mot_de_passe(Request $request)
    {
        $donnees_formulaire = $request->input();
        $identifiant = $donnees_formulaire['identifiant'];
//        dd($telephone);


        $notification = "<div class='alert alert-info'> Un message de recuperation de compte vous été envoyer par sms et par email. </div> ";
        $le_menbre = Menbre::where('telephone','=',$identifiant)->orWhere('email','=',$identifiant)->first();
//        dd($le_menbre);
        if($le_menbre != null){
            $nouveau_mdp = intdiv( time() ,99) * rand(1111,9999) ;
            $mdp_cacher = md5($nouveau_mdp);

            $telephone = $le_menbre->telephone;
            $message = "Bonjour,votre mot de passe a bien été reinitialiser, utilisez le nouveau mot de passe pour vous connecter puis changez le.             mot de passe : $nouveau_mdp ";
            SmsController::sms_info_bip($telephone,$message);

            $email = $le_menbre->email;
            if($email!=null){

                $headers = 'From: no-reply@waribana.com' . "\r\n";
                mail($email,'REINITIALISATION DE MOT DE PASSE',$message,$headers);
            }

//            dd($nouveau_mdp,$email);

            $le_menbre->mot_de_passe = $mdp_cacher;
            $le_menbre->save();
        }else{
            $notification = "<div class='alert alert-info'> Ce identifiant n'est associé à aucun compte. </div> ";
        }

        return redirect()->back()->with('notification',$notification);

    }

    public function inscription_menbre()
    {
        return view('inscription_menbre');
    }

    public function enregistrer_un_menbre(Request $request)
    {

        $couleur = "danger";

        $code_de_confirmation = rand(1111, 9999);

        $donnee_formulaire = $request->all();
        //        dd($donnee_formulaire);
        $nom_complet = $donnee_formulaire['nom_complet'];
        $pays = $donnee_formulaire['pays'];
        $ville = $donnee_formulaire['ville'];
        $adresse = $donnee_formulaire['adresse'];
        $etat_us = $donnee_formulaire['etat_us'];
        $code_postal = $donnee_formulaire['code_postal'];
        $prefix = $donnee_formulaire['prefixe'];
        $telephone = $donnee_formulaire['telephone'];
        $numero = $prefix.''.$telephone;
        $email = $donnee_formulaire['email'];
        $mot_de_passe = $donnee_formulaire['mot_de_passe'];
        $confirmer_mot_de_passe = $donnee_formulaire['confirmer_mot_de_passe'];

        //        dd($numero);
        //        ---------------Verifie existence des identifiant
        if ($email != null) {
            $route_connexion = route('connexion_menbre');
            $email_existe_deja = $this->checkExistenceEmail($email);
            if ($email_existe_deja) {
                $message = "Cette adresse email est déja utilisée. <a href='$route_connexion' >connectez-vous</a>";
                $notification = "<div class='alert alert-$couleur'> $message  </div>";
                return redirect()->route('inscription_menbre')->with('notification', $notification);
            }
        }
        $telephone_existe_deja = $this->checkExistenceNumero($numero);
        if ($telephone_existe_deja) {
            $message = "Ce numero ($numero) de telephone a déja utilisé. <a href='$route_connexion' >connectez-vous</a>";
            $notification = "<div class='alert alert-$couleur'> $message  </div>";
            return redirect()->route('inscription_menbre')->with('notification', $notification);
        }

        //        ---------------Verifie mot de passe et enregistrement

        if ($mot_de_passe != $confirmer_mot_de_passe) {
            $message = "Echec inscription, Les mots de passe ne sont pas identiques.";
        } else {
            $mot_de_passe_cacher = md5($confirmer_mot_de_passe);

            $le_menbre = new Menbre();
            $le_menbre->nom_complet = $nom_complet;
            $le_menbre->pays = $pays;
            $le_menbre->ville = $ville;
            $le_menbre->adresse = $adresse;
            $le_menbre->etat_us = $etat_us;
            $le_menbre->telephone = $code_postal;
            $le_menbre->telephone = $numero;
            $le_menbre->email = $email;
            $le_menbre->mot_de_passe = $mot_de_passe_cacher;
            $le_menbre->code_de_confirmation = $code_de_confirmation;
            $le_menbre->date_derniere_visite = null;

            //            dd($le_menbre);
            if ($le_menbre->save()) {

                $le_compte = CompteMenbre::findOrNew($le_menbre->id);
                $le_compte->id_menbre = $le_menbre->id;
                $le_compte->solde = 0;
                $le_compte->save();

                $couleur = "success";
                $message = "Inscription éffectuée, connectez-vous";
                $notification = "<div class='alert alert-$couleur'> $message  </div>";
                return redirect()->route('connexion_menbre')->with('notification', $notification);
            }
        }

        $notification = "<div class='alert alert-$couleur'> $message  </div>";
        return redirect()->route('inscription_menbre')->with('notification', $notification);


    }

    public function connexion(Request $request)
    {
        $donnees_formulaire = $request->all();
        
        $prefixe = $donnees_formulaire['prefixe'];
        $telephone = $donnees_formulaire['telephone'];
        // $identifiant = $donnees_formulaire['identifiant'];
        $identifiant = $prefixe . $telephone;
        $mot_de_passe = $donnees_formulaire['mot_de_passe'];

        $mot_de_passe_caher = md5($mot_de_passe);
//        $le_menbre = Menbre::where('email','=',$identifiant)->orWhere('telephone','=',$identifiant)->first();
        $le_menbre = Menbre::where('email', '=', $identifiant)
            ->orWhere('telephone', '=', $identifiant) ->first();

        if ($le_menbre != null) {
            if( $mot_de_passe_caher == $le_menbre->mot_de_passe ){
                $this->creer_session_menbre($le_menbre);
                return redirect()->route('espace_menbre.accueil');
            }else{
                $message = "mot de passe Incorrect";
                $notification = "<div class='alert alert-danger'> $message  </div>";
                return redirect()->route('connexion_menbre')->with('notification', $notification);
                return redirect()->route('connexion_menbre');
            }
        } else {
            $message = "Identifiant ou Mot de passe Incorrect";
            $notification = "<div class='alert alert-danger'> $message  </div>";
            return redirect()->route('connexion_menbre')->with('notification', $notification);
        }


    }

    public function confirmer_compte_menbre()
    {
        $la_session = session(MenbreController::$cle_session);
        if ($la_session == null) {
            return redirect()->route('connexion_menbre');
        } else {
            $id_menbre_connecter = $la_session['id'];
            $le_menbre = Menbre::find($id_menbre_connecter);
            if ($le_menbre == null) {
                return redirect()->route('connexion_menbre');
            } elseif ($le_menbre->etat != 'attente' && $le_menbre->devise !=null) {
                return redirect()->route('connexion_menbre');
            }
        }

        $les_devises = Devise::all();
        return view("espace_menbre/profil/confirmation_de_compte", compact('le_menbre','les_devises'));
    }

    public function post_confirmer_compte_menbre(Request $request)
    {
        $la_session = session(MenbreController::$cle_session);
        if ($la_session == null) {
            return redirect()->route('connexion_menbre');
        }
        else {
            $id_menbre_connecter = $la_session['id'];
            $le_menbre = Menbre::find($id_menbre_connecter);
            if ($le_menbre == null) {
                return redirect()->route('connexion_menbre');
            } elseif ($le_menbre->etat != 'attente') {
                return redirect()->route('connexion_menbre');
            }
        }

        $notification = "<div class='alert alert-danger'>Numero Invalide</div>";
        $donnees_formulaire = $request->all();
        $telephone = $donnees_formulaire['telephone'];
        $existe_pour_quelqun_dautre =  $this->checkExistenceNumeroPourAutrePersonne($telephone,$id_menbre_connecter);
        
        if (!$existe_pour_quelqun_dautre) {
            if (strlen($telephone) >= 10) {
                $le_menbre->telephone = $telephone;
                $le_menbre->save();
                $le_numero = "$telephone";
                $code = $le_menbre->code_de_confirmation;
        //                dd($code);
                $contenu_notification = SmsContenuNotification::first();
                $message_confirmation = $contenu_notification['confirmation_compte'];
                $le_message = str_replace('$code$',$code,$message_confirmation);
        //                dd($le_numero);
                SmsController::sms_info_bip($le_numero, $le_message);
                return redirect()->route('espace_menbre.entrer_code_confirmation');
            } else {
                return redirect()->back()->with('notification', $notification);
            }
        } else {
            
            $notification = "<div class='alert alert-danger'>Ce numero est deja associé a un autre compte</div>";
            return redirect()->back()->with('notification', $notification);
        };
        return view("espace_menbre/profil/confirmation_de_compte", compact('le_menbre'));
    }

    public function post_choisir_devise(Request $request)
    {
        $la_session = session(MenbreController::$cle_session);
        if ($la_session == null) {
            return redirect()->route('connexion_menbre');
        }
        else {
            $id_menbre_connecter = $la_session['id'];
            $le_menbre = Menbre::find($id_menbre_connecter);
            if ($le_menbre == null) {
                return redirect()->route('connexion_menbre');
            } elseif ($le_menbre->devise != null) {
                return redirect()->route('connexion_menbre');
            }
        }

        $notification = "<div class='alert alert-danger'>Devise invalide</div>";
        $donnees_formulaire = $request->all();
        $id_devise = $donnees_formulaire['id_devise'];
        $la_devise_existe = Devise::find($id_devise);
        if ($la_devise_existe!=null) {
            $le_menbre->devise = $id_devise;
            $le_menbre->save();

            $this->creer_session_menbre($le_menbre);

            return redirect()->route('espace_menbre.accueil');
        } else {
            return redirect()->back()->with('notification', $notification);
        };
        return view("espace_menbre/profil/confirmation_de_compte", compact('le_menbre'));
    }

    public function entrer_code_confirmation()
    {
        $la_session = session(MenbreController::$cle_session);
        if ($la_session == null) {
            return redirect()->route('connexion_menbre');
        } else {
            $id_menbre_connecter = $la_session['id'];
            $le_menbre = Menbre::find($id_menbre_connecter);
            if ($le_menbre == null) {
                return redirect()->route('connexion_menbre');
            } elseif ($le_menbre->etat != 'attente') {
                return redirect()->route('connexion_menbre');
            }
        }

        return view("espace_menbre/profil/entrer_code_confirmation", compact('le_menbre'));
    }

    public function post_entrer_code_confirmation(Request $request)
    {
        $la_session = session(MenbreController::$cle_session);
        if ($la_session == null) {
            return redirect()->route('connexion_menbre');
        } else {
            $id_menbre_connecter = $la_session['id'];
            $le_menbre = Menbre::find($id_menbre_connecter);
            if ($le_menbre == null) {
                return redirect()->route('connexion_menbre');
            } elseif ($le_menbre->etat != 'attente') {
                return redirect()->route('connexion_menbre');
            }
        }

        $donnees_formulaire = $request->all();
        $le_code = $donnees_formulaire['code'];
        if ($le_code == $le_menbre->code_de_confirmation) {
            $le_menbre->etat = 'actif';
            $le_menbre->save();
            return redirect()->route('espace_menbre.accueil');
        } else {
            $notification = "<div class='alert alert-danger text-center'>code invalide, rééssayez.</div>";
            return redirect()->back()->with('notification', $notification);
        }
        return view("espace_menbre/entrer_code_confirmation", compact('le_menbre'));
    }


    #========================Utilitaire============================#
    private function checkExistenceEmail($email)
    {
        $menbre_existant = Menbre::where('email', '=', $email)->first();
        if ($menbre_existant != null) {
            return true;
        } else {
            return false;
        }
    }

    private function checkExistenceNumero($numero)
    {
        $menbre_existant = Menbre::where('telephone', '=', $numero)->first();
        if ($menbre_existant != null) {
            return true;
        } else {
            return false;
        }
    }

    private function creer_session_menbre($le_menbre)
    {
        $id_menbre = $le_menbre->id;
        $nom_complet = $le_menbre->nom_complet;
        if($le_menbre->devise_choisie !=null){
            $devise = $le_menbre->devise_choisie->monaie;
            $code_devise = $le_menbre->devise_choisie->code;
        }else{
            $devise ='---';
            $code_devise ='--';
        }
        session()->put(MenbreController::$cle_session, ['id' => $id_menbre, 'nom_complet' => $nom_complet, 'devise' => $devise,'code_devise'=>$code_devise]);
    }

    

    private function checkExistenceNumeroPourAutrePersonne($numero,$id_menbre){
        $menbre_existant = Menbre::where('telephone','=',$numero)->where('id','!=',$id_menbre)->first();
        
        if($menbre_existant != null){
            return true;
        }else{
            return false;
        }
    }
}
