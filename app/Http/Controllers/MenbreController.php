<?php

namespace App\Http\Controllers;

use App\Models\CompteMenbre;
use App\Models\Menbre;
use Illuminate\Http\Request;

class MenbreController extends Controller
{

    public static $cle_session = "menbre_waribana_connecter";


    public function connexion_menbre()
    {
//        $this->sms_info_bip();
//        $this->envoyer_sms();
        return view('connexion_menbre');

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
        $telephone = $donnee_formulaire['telephone'];
        $email = $donnee_formulaire['email'];
        $mot_de_passe = $donnee_formulaire['mot_de_passe'];
        $confirmer_mot_de_passe = $donnee_formulaire['confirmer_mot_de_passe'];

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
        $telephone_existe_deja = $this->checkExistenceNumero($telephone);
        if ($telephone_existe_deja) {
            $message = "Ce numero de telephone a déja utilisé. <a href='$route_connexion' >connectez-vous</a>";
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
            $le_menbre->telephone = $telephone;
            $le_menbre->email = $email;
            $le_menbre->mot_de_passe = $mot_de_passe_cacher;
            $le_menbre->code_de_confirmation = $code_de_confirmation;

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
        $identifiant = $donnees_formulaire['identifiant'];
        $mot_de_passe = $donnees_formulaire['mot_de_passe'];

        $mot_de_passe_caher = md5($mot_de_passe);
//        $le_menbre = Menbre::where('email','=',$identifiant)->orWhere('telephone','=',$identifiant)->first();
        $le_menbre = Menbre::where('email', '=', $identifiant)->orWhere('telephone', '=', $identifiant)->where('mot_de_passe', '=', $mot_de_passe_caher)->first();

        if ($le_menbre != null) {
            $this->creer_session_menbre($le_menbre);
            return redirect()->route('espace_menbre.accueil');
        } else {
            $couleur = "danger";
            $message = "Identifiant ou Mot de passe Incorrect";
            $notification = "<div class='alert alert-$couleur'> $message  </div>";
            return redirect()->route('connexion_menbre')->with('notification', $notification);
            return redirect()->route('connexion_menbre');
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
            } elseif ($le_menbre->etat != 'attente') {
                return redirect()->route('connexion_menbre');
            }
        }

        return view("espace_menbre/confirmation_de_compte", compact('le_menbre'));
    }

    public function post_confirmer_compte_menbre(Request $request)
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

        $notification = "<div class='alert alert-danger'>Numero Invalide</div>";
        $donnees_formulaire = $request->all();
        $telephone = $donnees_formulaire['telephone'];
        if (is_numeric($telephone)) {
            if (strlen($telephone) == 10) {
                $le_menbre->telephone = $telephone;
                $le_menbre->save();
                $le_numero = "225$telephone";
                $code = $le_menbre->code_de_confirmation;
//                dd($code);
                $le_message = "Votre code de cobnfirmation est $code";
//                dd($le_numero);
                SmsController::sms_info_bip($le_numero, $le_message);
                return redirect()->route('espace_menbre.entrer_code_confirmation');
            } else {
                return redirect()->back()->with('notification', $notification);
            }
        } else {
            return redirect()->back()->with('notification', $notification);
        };
        return view("espace_menbre/confirmation_de_compte", compact('le_menbre'));
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

        return view("espace_menbre/entrer_code_confirmation", compact('le_menbre'));
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
        session()->put(MenbreController::$cle_session, ['id' => $id_menbre, 'nom_complet' => $nom_complet]);
    }


    function envoyer_sms()
    {

        $login = "personnepersonnepersonneperson@gmail.com";
        $apikey = "zLCZOElBHe2pUTk80Fm1swdDxrXPWNia";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.octopush.com/v1/public/sms-campaign/send");
        curl_setopt($ch, CURLOPT_POST, true);


        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
            "api-key:$apikey",
            "api-login:$login",
            "Cache-Control:no-cache",
            "Accept:application/json",
            "cache-control:no-cache"
        ));

        $datas = array(
            "recipients" => [
                "phone_number" => "+2250555994041",
                "first_name" => "Axelle",
                "last_name" => "Durand",
                "param3" => "Mme",
                "text" => "Voici un SMS Premium avec mention STOP. STOP au 30101",
                "type" => "sms_premium", "purpose" => "wholesale", "sender" => "Entreprise"
            ]
        );

        // dd($les_donnees,json_encode($datas));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $les_donnees);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datas));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//recuperer le contenu de notre requete

        $response = curl_exec($ch); //executer et recuperer la reponse

        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        curl_close($ch);
        dd($response);
    }

}
