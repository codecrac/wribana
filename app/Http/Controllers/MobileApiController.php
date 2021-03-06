<?php

namespace App\Http\Controllers;

use App\Models\Waricrowd;
use App\Models\Menbre;
use App\Models\Invitation;
use App\Models\Tontine;
use App\Models\MenbreTontine;
use App\Models\CaisseTontine;
use App\Models\Transaction;
use App\Models\TransactionWaricrowd;
use App\Models\TransactionTransfertWaribank;
use App\Models\CahierCompteTontine;
use App\Models\CompteMenbre;
use App\Models\CategorieWaricrowd;
use App\Models\CaisseWaricrowd;
use App\Models\WaricrowdMenbre;
use App\Models\Devise;

use App\Http\Controllers\SmsController;
use App\Models\SmsContenuNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Storage;

class MobileApiController extends Controller
{

//===================VITRINE#VITRINE---#----VITRINE#VITRINE--------#----------VITRINE#VITRINE#VITRINE#VITRINE#VITRINE
    public function liste_crowd(Request $request,$index_pagination=0)
    {
        if($request->query('id_categorie')){
            $id_categorie = $request->query('id_categorie');
            $les_crowds = Waricrowd::orderBy('id','DESC')
                            ->where('id_categorie','=',$id_categorie)
                            ->where('etat','=','valider')
                            ->with('categorie')
                            ->with('createur')
                            ->with('caisse')
                            ->skip($index_pagination)
                            ->limit(100)
                            ->get();    
        }else{
            $les_crowds = Waricrowd::orderBy('id','DESC')->where('etat','=','valider')->with('categorie')->with('createur')
            ->with('caisse')->skip($index_pagination)->limit(100)->get();    
        }
        
        return $les_crowds;
        // return json_encode($les_crowds);
    }


    public function modifier_infos_genrale_dun_menbre(Request $request,$id_menbre)
    {


        $donnee_formulaire = $request->all();
        $nom_complet = $donnee_formulaire['nom_complet'];
        $pays = $donnee_formulaire['pays'];
        $ville = $donnee_formulaire['ville'];
        $adresse = $donnee_formulaire['adresse'];
        $etat_us = $donnee_formulaire['etat_us'];
        $code_postal = $donnee_formulaire['code_postal'];
        $email = $donnee_formulaire['email'];

        if( empty($nom_complet) || empty($pays) || 
        empty($ville) || empty($adresse) ){
            
            $message = "Tous les champs avec (*) sont obligatoire" ;
            $reponse = array(
                "success" => false,
                "message" => $message,
            );
            return $reponse;
        }


        //        ---------------Verifie existence des identifiant
        if ($email != null) {
            $email_existe_deja = $this->checkExistenceEmailPourAutrePersonne($email,$id_menbre);
            if ($email_existe_deja) {
                $message = "Cette adresse email est d??ja utilis??e.";
                $reponse = array(
                    "success" => false,
                    "message" => $message,
                );
                return $reponse;
            }
        }
       
        $le_menbre = Menbre::find($id_menbre);
        $le_menbre->nom_complet = $nom_complet;
        $le_menbre->pays = $pays;
        $le_menbre->ville = $ville;
        $le_menbre->adresse = $adresse;
        $le_menbre->etat_us = $etat_us;
        $le_menbre->email = $email;
        $le_menbre->code_postal = $code_postal;
        $le_menbre->save();

        $success = true;
        $message = "Votre profil a bien ??t?? modifi??";

        
        $reponse = array(
            "success" => $success,
            "message" => $message,
        );
        return $reponse;

    }

    public function modifier_mot_de_passe_dun_menbre(Request $request,$id_menbre)
    {

        $donnee_formulaire = $request->all();
        $mot_de_passe_actuel = $donnee_formulaire['mot_de_passe_actuel'];
        $bon_mot_de_passe = $this->VerifieLeMotDePasse($mot_de_passe_actuel,$id_menbre);

        if($bon_mot_de_passe){
            $mot_de_passe = $donnee_formulaire['nouveau_mot_de_passe'];
            $confirmer_mot_de_passe = $donnee_formulaire['confirmer_nouveau_mot_de_passe'];
           
            $le_menbre = Menbre::find($id_menbre);
            if(!empty($mot_de_passe) && !empty($confirmer_mot_de_passe) ){
                if($mot_de_passe != $confirmer_mot_de_passe){
                    $couleur = "danger";
                    $message = "Les mots de passe ne sont pas identiques.";
                    $reponse = array(
                        "success" => false,
                        "message" => $message,
                    );
                }else{
                    $mot_de_passe_cacher = md5($confirmer_mot_de_passe);
                    $le_menbre->mot_de_passe = $mot_de_passe_cacher;
                    $le_menbre->save();
                    $message = "Modification du mot de passe effectu??e ";
                    $reponse = array(
                        "success" => true,
                        "message" => $message,
                    );
                }            
            }else{
                $reponse = array(
                    "success" => false,
                    "message" => "Nouveau mot de passe invalide (vide)",
                );
            }

        }else{
            
            $reponse = array(
                "success" => false,
                "message" =>  "Mot de passe actuel incorrect",
            );
        }

        return $reponse;
    }


    public function modifier_telephone_compte(Request $request,$id_menbre_connecter,$telephone)
    {
        //nouveau code
        $code_de_confirmation = rand(1111, 9999) * 12;
        $le_menbre = Menbre::find($id_menbre_connecter);
        $le_menbre->code_de_confirmation = $code_de_confirmation;
        $le_menbre->save();

        $notification = "Numero Invalide";
        // $donnees_formulaire = $request->input();
        // $telephone = $donnees_formulaire['nouveau_telephone'];
        if (is_numeric($telephone)) {
            if($telephone == $le_menbre->telephone){
                $reponse = array(
                    "success" => false,
                    "message" => "Modification effectu??e",
                );
            }
            else{
                    if (!($this->checkExistenceNumeroPourAutrePersonne($telephone,$id_menbre_connecter))) {
                        $le_numero = $telephone;
                        $code = $code_de_confirmation;
                        $contenu_notification = SmsContenuNotification::first();
                        $message_confirmation = $contenu_notification['confirmation_compte'];
                        $le_message = str_replace('$code$',$code,$message_confirmation);
                        SmsController::sms_info_bip($le_numero, $le_message);

                        $reponse = array(
                            "success" => true,
                            "message" => "un message de confirmation vous a ??t?? envoy??",
                        );
                     }else{
                        $reponse = array(
                            "success" => false,
                            "message" => "Ce numero a deja ??t?? utilis??",
                        );
                     }
            }
        } else {
              $reponse = array(
                        "success" => false,
                        "message" => "Numero Invalide",
                    );
        };
        return $reponse;
    }

    public function post_code_confirmation_changer_tel(Request $request,$id_menbre_connecter){
        $donnees_formulaire = $request->all();
        $le_code = $donnees_formulaire['code_confirmation'];
        $nouveau_telephone = $donnees_formulaire['nouveau_telephone'];
        $le_menbre = Menbre::find($id_menbre_connecter);
        if ($le_code == $le_menbre->code_de_confirmation) {
            $le_menbre->telephone = $nouveau_telephone;
            $le_menbre->save();
            $success = true;
            $message = "Operation bien effectu??e";
        }else {
            $success = false;
            $message = "code invalide, r????ssayez.";
        }
        $reponse = array(
            "success" => $success,
            "message" => $message,
        );
        return $reponse;
    }

    public function enregistrer_un_menbre(Request $request)
    {

        $code_de_confirmation = rand(1111, 9999);

        $donnee_formulaire = $request->all();
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

        if( empty($nom_complet) || empty($pays) || 
        empty($ville) || empty($adresse) || empty($prefix)
         || empty($telephone) || empty($mot_de_passe) ){
            
            $message = "Tous les champs avec (*) sont obligatoire" ;
            $reponse = array(
                "success" => false,
                "message" => $message,
            );
            return $reponse;
        }


        //        ---------------Verifie existence des identifiant
        if ($email != null) {
            $email_existe_deja = $this->checkExistenceEmail($email);
            $route_connexion = route('connexion_menbre');
            if ($email_existe_deja) {
                $message = "Cette adresse email est d??ja utilis??e.";
                $reponse = array(
                    "success" => false,
                    "message" => $message,
                );
                return $reponse;
            }
        }
        $telephone_existe_deja = $this->checkExistenceNumero($numero);
        if ($telephone_existe_deja) {
            $message = "Ce numero ($numero) de telephone a d??ja utilis??.";
            
            $reponse = array(
                "success" => false,
                "message" => $message,
            );
            return $reponse;
        }

        //        ---------------Verifie mot de passe et enregistrement

        if ($mot_de_passe != $confirmer_mot_de_passe) {
            $success = false;
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

                $success = true;
                $message = "Inscription ??ffectu??e, connectez-vous";
            }
        }

        
        $reponse = array(
            "success" => $success,
            "message" => $message,
        );
        return $reponse;

    }

    public function connexion(Request $request)
    {
        
        $message = "";
        $reponse = [
            'success'=>false,
            'message'=>$message
        ];
        $donnees_formulaire = $request->all();
        
        $prefixe = $donnees_formulaire['prefixe'];
        $telephone = $donnees_formulaire['telephone'];
        // $identifiant = $donnees_formulaire['identifiant'];
        $identifiant = $prefixe . $telephone;
        $mot_de_passe = $donnees_formulaire['mot_de_passe'];

        $mot_de_passe_caher = md5($mot_de_passe);

        $le_menbre = Menbre::where('email', '=', $identifiant)
            ->orWhere('telephone', '=', $identifiant) ->first();

        if ($le_menbre != null) {
            if( $mot_de_passe_caher == $le_menbre->mot_de_passe ){
                $reponse['success'] = true;
                $message = "connecte";
                $reponse["message"] = $message;
                $reponse = $this->creer_session_menbre($reponse,$le_menbre);
            }else{
                $message = "mot de passe Incorrect";
                $reponse["message"] = $message;
            }
        } else {
            $message = "Identifiant ou Mot de passe Incorrect";
            $reponse["message"] = $message;
        }

        
        return json_encode($reponse);

    }

    public function details_menbre($id_menbre)
    {
        if(isset($_GET['is_waribank'])){ $is_waribank = true;}else{$is_waribank = false;} ;
        
        $le_menbre = Menbre::find($id_menbre);
        $le_menbre['devise'] = $le_menbre->devise_choisie->monaie;
        $le_menbre['code_devise'] = $le_menbre->devise_choisie->code;
        
        if($is_waribank){
            $le_menbre->compte;
            $le_menbre->historique_transfert_entrant;
            $le_menbre->historique_tranfert_sortant;
            $le_menbre->historique_rechargement;
            $le_menbre->historique_retraits;
            $le_menbre->historique_virement_tontine;
        }
        
        return json_encode($le_menbre);

    }
    
    public function confirmer_compte_menbre(Request $request,$id_menbre_connecter)
    {
        $le_menbre = Menbre::find($id_menbre_connecter);
        if ($le_menbre == null) {
            
            $reponse = array(
                "success" => false,
                "message" => "utilisateur invalide",
            );
            return json_encode($reponse);
        }

        $notification = "Numero Invalide";
        $donnees_formulaire = $request->all();
        $telephone = $donnees_formulaire['telephone'];

        $existe_pour_quelqun_dautre = $this->checkExistenceNumeroPourAutrePersonne($telephone,$id_menbre_connecter);
        if($existe_pour_quelqun_dautre){
            
            $reponse = array(
                "success" => false,
                "message" => "Ce numero appartient a un autre menbre",
            );
            return json_encode($reponse);
        }

        if (is_numeric($telephone)) {
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

                
                    $reponse = array(
                        "success" => true,
                        "message" => "Un code de confirmation vous a ete envoy??",
                    );
                    return json_encode($reponse);
                
        } 
        
        $reponse = array(
            "success" => false,
            "message" => $notification,
        );
        return json_encode($reponse);
    }

    public function entrer_code_de_confirmation_et_choisir_devise(Request $request, $id_menbre_connecter)
    {

        $le_menbre = Menbre::find($id_menbre_connecter);
        if ($le_menbre == null) {
            $reponse = array(
                "success" => false,
                "message" => "utilisateur invalide",
            );
            return json_encode($reponse);
        }

        $donnees_formulaire = $request->all();
        $le_code_de_confirmation = $donnees_formulaire['code_confirmation'];
        $le_code_devise = $donnees_formulaire['code_devise'];

        if(empty($le_code_de_confirmation) || empty($le_code_devise)){
            
            $reponse = array(
                "success" => false,
                "message" => "Veuillez renseigner le code",
            );
            return json_encode($reponse);
        }

        $la_devise = Devise::where('code','=',$le_code_devise)->first();

        if ($le_code_de_confirmation == $le_menbre->code_de_confirmation) {
            $le_menbre->etat = 'actif';
            $le_menbre->devise = $la_devise->id;
            $le_menbre->save();
            
            $reponse = array(
                "success" => true,
                "message" => "confirmation effectuee",
            );
            
        } else {
            $reponse = array(
                "success" => false,
                "message" => "code invalide, r????ssayez",
            );
        }
        
        return json_encode($reponse);
    }

    public function reinitialiser_mot_de_passe($identifiant)
    {

        $notification = "Un message de recuperation de compte vous ??t?? envoyer par sms et par email";
        $le_menbre = Menbre::where('telephone','=',$identifiant)->orWhere('email','=',$identifiant)->first();
        //        dd($le_menbre);
        if($le_menbre != null){
            $nouveau_mdp = intdiv( time() ,99) * rand(1111,9999) ;
            $mdp_cacher = md5($nouveau_mdp);

            $telephone = $le_menbre->telephone;
            $message = "Bonjour,

Votre mot de passe a bien ??t?? r??initialis??, utilisez le nouveau mot de passe pour vous connecter puis changez le.
 
Mot de passe : $nouveau_mdp ";
            SmsController::sms_info_bip($telephone,$message);

            $email = $le_menbre->email;
            if($email!=null){
                $headers = 'From: waribana@waribana.net' . "\r\n" .
                 'Reply-To: no-reply@waribana.net' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();
                mail($email,'REINITIALISATION DE MOT DE PASSE',$message,$headers);
            }

            $le_menbre->mot_de_passe = $mdp_cacher;
            $le_menbre->save();
        }else{
            $notification = "Ce identifiant n'est associ?? ?? aucun compte";
        }

        $reponse = array(
            "success" => true,
            "message" => $notification,
        );
        return $reponse;

    }

//===================espace MEMBRE#espace MEMBRE---#----espace MEMBRE#espace MEMBRE--------#----------????????????????????????????
   
#===============TONTINE==========TONTINE==========TONTINE==========
    public function infos_pour_tableau_de_bord($id_menbre)
    {
        $le_menbre = Menbre::find($id_menbre);
        // dd($le_menbre);
        $email_inviter = $le_menbre->email;
        $telephone_inviter = $le_menbre->telephone;
        $invitation_recues = [];
        $nb_invitation_recues =0;
        if($email_inviter!=null){
            $nb_invitation_recues = Invitation::where('email_inviter','=',$email_inviter)->where('etat','=','attente')->orWhere('email_inviter','=',$telephone_inviter)->where('etat','=','invitation envoyee')->count();
        }

        $infos_pour_tableau_de_bord = [];
        $infos_pour_tableau_de_bord['nb_tontine'] = sizeof($le_menbre->tontines);
        $infos_pour_tableau_de_bord['nb_invitations_recues'] = $nb_invitation_recues;
        $infos_pour_tableau_de_bord['nb_waricrowd'] = sizeof($le_menbre->mes_waricrowd);

        if($le_menbre->projets_soutenus !=null){
            $infos_pour_tableau_de_bord['nb_projets_soutenus'] = sizeof($le_menbre->projets_soutenus);
        }else{
            $infos_pour_tableau_de_bord['nb_projets_soutenus'] = 0;
        }

        $infos_pour_tableau_de_bord['solde'] = $le_menbre->compte->solde ." ". $le_menbre->devise_choisie->monaie;
        // return $infos_pour_tableau_de_bord;
        return json_encode($infos_pour_tableau_de_bord);
    }

    public function details_profil_utilisateur($id_menbre)
    {
        $lutilisateur = Menbre::where('id','=',$id_menbre)->first();
        return json_encode($lutilisateur);
    }
    
    public function enregistrer_tontine(Request $request,$id_menbre_connecter)
    {
        $donnees_formulaire = $request->input();
        //        dd($donnees_formulaire);

        $identifiant_adhesion = intdiv( (rand(111,999) * rand(11,99)) ,12 );
        $titre = $donnees_formulaire['titre'];
        $montant = $donnees_formulaire['montant'];
        $frequence_de_depot = $donnees_formulaire['frequence_depot_en_jours'];
        $nombre_participant = $donnees_formulaire['nombre_participant'];

        if(empty($titre) || empty($montant) || empty($frequence_de_depot) || empty($nombre_participant) ){
            $reponse = array(
                "success" => false,
                "message" => "Veuillez renseignez tous les champs",
            );
            return json_encode($reponse);
        }

        if(!empty($titre) && !empty($montant) && !empty($frequence_de_depot) && !empty($nombre_participant)){
            $la_tontine = new Tontine();

            $la_tontine->identifiant_adhesion = $identifiant_adhesion;
            $la_tontine->titre = $titre;
            $la_tontine->montant = $montant;
            $la_tontine->frequence_depot_en_jours = $frequence_de_depot;
            $la_tontine->nombre_participant = $nombre_participant;
            $la_tontine->id_menbre = $id_menbre_connecter;

            if($la_tontine->save()){
                $menbre_tontine = new MenbreTontine();
                $menbre_tontine->menbre_id = $id_menbre_connecter;
                $menbre_tontine->tontine_id = $la_tontine->id;
                if($menbre_tontine->save()){
                    $route_details_tontine = route('espace_menbre.details_tontine',[$la_tontine->id]);
                    $notification = "la tontine ($la_tontine->titre) a bien ??t?? cr????";
                }else{
                    $notification = "Un probleme est survenu";
                }

            }else{
                $notification = "Echec de l'Operation, veuillez r????ssayer";
            }

            $reponse = array(
                "success" => true,
                "id_tontine" => $la_tontine->id,
                "message" => $notification
            );

            return $reponse;
            //  redirect()->route('espace_menbre.ajouter_tontine')->with('notification',$notification);
        }
    }

    public function liste_tontine($id_menbre)
    { //les tontines de l'utilisateur connecter
        $le_menbre = Menbre::find($id_menbre);
    
        $les_tontines = $le_menbre->mes_tontines_pour_mobile;
        return json_encode($les_tontines);
    }
    
    public function details_tontine($id_tontine,$id_menbre_connecter)
    {


        $la_tontine = Tontine::where('id','=',$id_tontine)->with('caisse')->with('createur')->with('participants')->first();

        $id_menbre_qui_prend =null;
        if($la_tontine->caisse != null){
            $id_menbre_qui_prend = $la_tontine->caisse->menbre_qui_prend->id;
        }

        $invitations_envoyees = Invitation::where("menbre_qui_invite",'=',$id_menbre_connecter)->where('id_tontine','=',$id_tontine)->get();
        if($la_tontine ==null){
            $message = "tontine invalide";
        }


        if($la_tontine->caisse!=null){

            //Eviter paiement multiple de cotisation par la meme personne pour le meme tour
            $a_deja_cotiser = Transaction::where("id_menbre",'=',$id_menbre_connecter)
                ->where('id_tontine','=',$id_tontine)
                ->where('id_menbre_qui_prend','=',$la_tontine->caisse->menbre_qui_prend->id)
                ->where('index_ouverture','=',$la_tontine->caisse->index_ouverture)
                ->where('statut','=','ACCEPTED')
                ->first();
            $a_deja_cotiser = ($a_deja_cotiser!=null) ? true : false;

            //Liste des transaction pour le tour courant
            $liste_ayant_cotiser = Transaction::where('id_tontine','=',$id_tontine)
                ->where('statut','=','ACCEPTED')
                ->where('id_menbre_qui_prend','=',$la_tontine->caisse->menbre_qui_prend->id)
                ->where('index_ouverture','=',$la_tontine->caisse->index_ouverture)
                ->with('cotiseur')
                ->get();
        }else{
            $liste_ayant_cotiser = [];
            $a_deja_cotiser = false;
        }

        //a decoder a la notication;utiliser pour recuperer la trasaction sans l'id
        $notre_custom_field = "id_menbre=$id_menbre_connecter&id_tontine=$id_tontine&id_menbre_qui_prend=$id_menbre_qui_prend";
        //        parse_str($a, $output);
        
        
        $la_tontine['a_deja_cotiser'] = $a_deja_cotiser;
        $la_tontine['liste_ayant_cotiser'] = $liste_ayant_cotiser;
        
        return $la_tontine;
    }

    public function modifier_tontine(Request $request,$id_tontine)
    {
        $donnees_formulaire = $request->all();

        $titre = $donnees_formulaire['titre'];
        $montant = $donnees_formulaire['montant'];
        $frequence_de_depot = $donnees_formulaire['frequence_depot_en_jours'];
        $nombre_participant = $donnees_formulaire['nombre_participant'];

        if(!empty($titre) && !empty($montant) && !empty($frequence_de_depot) && !empty($nombre_participant)){
            $la_tontine = Tontine::find($id_tontine);

            if($la_tontine ==null){
                $reponse = array(
                    "success" => false,
                    "message" => "tontine invalide"
                );
                return $reponse;
            }


            //il ne peut pas modifier la tontines apres que des gens ai payer
            if(sizeof($la_tontine->transactions) <1 ){
                $la_tontine->titre = $titre;
                $la_tontine->montant = $montant;
                $la_tontine->frequence_depot_en_jours = $frequence_de_depot;
                $la_tontine->nombre_participant = $nombre_participant;
                
                
                if($la_tontine->caisse!=null){
                    
                    $la_caisse_tontine = $la_tontine->caisse;
                    $la_caisse_tontine->montant_objectif = $la_tontine->montant * $la_tontine->nombre_participant;
                    $la_caisse_tontine->montant_a_verser = $la_caisse_tontine->montant_objectif - ($la_caisse_tontine->montant_objectif * (1/100) );
                    // dd($la_caisse_tontine->montant_a_verser);
                    $la_caisse_tontine->save();
                }
            }

            if($la_tontine->save()){
                $message = "Operation bien ??ffectu??e";
            }else{
                $message = "Echec de l'Operation, veuillez r????ssayer";
            }

            $reponse = array(
                "success" => true,
                "message" => $message,
            );
            return $reponse;
        }
    }

    
    public function supprimer_la_tontine(Request $request,$id_tontine,$id_menbre)
    {
        $la_tontine = Tontine::find($id_tontine);
        //        dd($la_tontine->transactions);
        $success = false;
        $notification = "tontine invalide";
        if($la_tontine){
            if(sizeof($la_tontine->transactions) == 0 && $la_tontine->id_menbre == $id_menbre ){
                $la_tontine->delete();
                $notification = "Supression de La tontine ($la_tontine->titre) reussie.";
                $success = true;
            }else{
                $success = false;
                $notification = "Vous ne pouvez pas supprimer une tontine apres que des transactions ai ??t?? effectu??es";
            }
        }
        
        return json_encode(
            array(
                "success" => $success,
                "message" => $notification,
            )
        );
    }

    public function ouvrir_tontine($id_tontine)
    {
        
        $la_tontine = Tontine::find($id_tontine);
        if($la_tontine->etat =="prete"){
                $la_tontine->etat = 'ouverte';
                $la_tontine->save();

                //la date prochaine on ajoute le nombre de jour definit dans la frequence de pot a partir d'aujourd'hui
                $aujourdhui = new \DateTime("now", new \DateTimeZone("UTC"));
                $aujourdhui = $aujourdhui->format("d-m-Y");
                $nombre_de_jours_en_plus = $la_tontine->frequence_depot_en_jours;
                $prochaine_date_encaissement = date('d-m-Y', strtotime($aujourdhui. " + $nombre_de_jours_en_plus days"));

                // on cree la caisse dedie a la tontine et on commence par le menbre qui a creer la tontine
                $la_caisse_de_la_tontine = CaisseTontine::findOrNew($id_tontine);
                $la_caisse_de_la_tontine->id_tontine= $la_tontine->id;

                //pour gerer les reouverture de tontine
                if($la_caisse_de_la_tontine->index_ouverture != null){
                    $index_actuel = $la_caisse_de_la_tontine->index_ouverture;
                    $la_caisse_de_la_tontine->index_ouverture = $index_actuel + 1;
                }

                $montant_objectif = $la_tontine->montant * $la_tontine->nombre_participant;
                $frais_de_gestion = round( $montant_objectif * (1/100) );
                $montant_moins_frais = $montant_objectif - $frais_de_gestion;

                $la_caisse_de_la_tontine->montant_objectif= $montant_objectif;
                $la_caisse_de_la_tontine->frais_de_gestion= $frais_de_gestion;
                $la_caisse_de_la_tontine->montant_a_verser= $montant_moins_frais;
        //        $la_caisse_de_la_tontine->montant= 0;
                $la_caisse_de_la_tontine->id_menbre_qui_prend= $la_tontine->id_menbre;
                $la_caisse_de_la_tontine->prochaine_date_encaissement= $prochaine_date_encaissement;
                $la_caisse_de_la_tontine->save();

                //notifier les participant de l'ouverture
                $contenu_notification = SmsContenuNotification::first();
                $message_notif = $contenu_notification['etat_tontine'];

                $le_message = str_replace('$etat$',"ouverte",$message_notif);
                $le_message = str_replace('$titre$',$la_tontine->titre,$le_message);
                $le_message = str_replace('$motif$',"",$le_message);

                foreach($la_tontine->participants as $item_participant){
                    SmsController::sms_info_bip($item_participant->telephone,$le_message);
                }
                

                $message = "La tontine a bien ??t?? ouverte ";
                $success = true;
            }else{
                $message = "Echec de l'operation ";
                $success = true;
            }
        $reponse = array(
            "success" => $success,
            "message" => $message,
        );
        return $reponse;
        
    }

    public function initier_paiement_rechargement(Request $request,$id_menbre_connecter)
    {
            //================INTEGRATION CINETPAY===================
                $donnees_formulaire = $request->all();
                $le_montant = $donnees_formulaire['montant_recharge'];

                $le_menbre = Menbre::find($id_menbre_connecter);
          
            // CONVERSION EN CFA AVANT PAIEMENT
                if($le_menbre->devise_choisie->code != "XOF"){
                    $monaie_createur_tontine = $le_menbre->devise_choisie->code;
                    $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion(
                        $monaie_createur_tontine,"XOF");
                    $le_montant_en_xof = $quotient_de_conversion * $le_montant;
                }else{
                    $le_montant_en_xof = $le_montant;
                }
            // CONVERSION EN CFA AVANT PAIEMENT
        
                $route_back_en_cas_derreur = route('api.mobile.statut_transaction');
                $payment_url = CinetpayPaiementController::generer_lien_paiement($le_menbre,$le_montant_en_xof,$le_montant,$route_back_en_cas_derreur,true);
            

                $reponse = array(
                    "success" => true,
                    "url_paiement" => $payment_url,
                    "message" => $payment_url
                );

                return $reponse;
    }

    public function effectuer_tranfert_waribank(Request $request,$id_menbre_connecter)
    {
        $success =false;
        $df = $request->all();
        $mot_de_passe_actuel = $df['mot_de_passe_actuel'];
        $montant_en_monaie_expediteur = $df['montant'];
        $numero_complet = $df['telephone'];

        $notification ="ntohing";
        if(empty($mot_de_passe_actuel) || empty($montant_en_monaie_expediteur) || empty($numero_complet) ){
            
            $reponse = array(
                "success" => false,
                "message" => "Tous les champs sont obligatoire"
            );
            return json_encode($reponse);
        }

        $le_menbre = Menbre::find($id_menbre_connecter);
        $bon_mot_de_passe = $this->VerifieLeMotDePasse($mot_de_passe_actuel,$id_menbre_connecter);
        if($bon_mot_de_passe){
            $le_destinataire = Menbre::where('telephone','=',$numero_complet)->first();
            if($le_destinataire !=null){
                if( $le_menbre->compte->solde >= $montant_en_monaie_expediteur){

                    // CONVERSION EN CFA AVANT PAIEMENT
                    if($le_menbre->devise_choisie->code != $le_destinataire->devise_choisie->code){
                        $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion(
                            $le_menbre->devise_choisie->code ,$le_destinataire->devise_choisie->code);
                        
                            $le_montant_equivalent_pour_destinataire = $quotient_de_conversion * $montant_en_monaie_expediteur;
                    }else{
                        $le_montant_equivalent_pour_destinataire = $montant_en_monaie_expediteur;
                    }


                            $nom_complet_exp = strtolower($le_menbre->nom_complet);
                            $compte_expediteur = $le_menbre->compte;
                            $compte_expediteur->solde = $compte_expediteur->solde - $montant_en_monaie_expediteur;
                            $compte_expediteur->save();
                            $monaie_exp = $le_menbre->devise_choisie->monaie;
                    
                            $compte_destinataire = $le_destinataire->compte;
                            $compte_destinataire->solde = $compte_destinataire->solde + $le_montant_equivalent_pour_destinataire;
                            $compte_destinataire->save();
                            $monaie_dest = $le_destinataire->devise_choisie->monaie;
                            
                            $numero_destinataire = $le_destinataire->telephone;
                            $le_message_dest = "Vous avez recu un depot de $montant_en_monaie_expediteur $monaie_exp ($le_montant_equivalent_pour_destinataire $monaie_dest) de $le_menbre->nom_complet avec succes";
                            $le_message_exp = "Votre transfert de $montant_en_monaie_expediteur $monaie_exp ($le_montant_equivalent_pour_destinataire $monaie_dest) a $le_destinataire->nom_complet ($numero_destinataire) a bien ??t?? ??ffectu??";
                            
                            SmsController::sms_info_bip($le_menbre->telephone, $le_message_exp);
                            SmsController::sms_info_bip($le_destinataire->telephone, $le_message_dest);
                    
                            $la_transaction = new TransactionTransfertWaribank();
                            $la_transaction->id_menbre = $le_menbre->id;
                            $la_transaction->id_destinataire = $le_destinataire->id;
                            $la_transaction->telephone = $numero_destinataire;
                            $la_transaction->montant_monaie_expediteur = $montant_en_monaie_expediteur;
                            $la_transaction->montant_equivalent_destinataire = $le_montant_equivalent_pour_destinataire;
                            $la_transaction->save();
                    
                            $success = true;
                            $notification = "Transfert au $numero_destinataire [ $le_destinataire->nom_complet  ]  bien effectu??.";
                            
                   
                    $id_destinataire = $le_destinataire->id;
                }else{
                    $notification = "Votre solde est insuffisant.";    
                }
            }else{
                $notification = "Ce numero ($numero_complet) n'est associ?? a aucun compte";
            }
        }else{
            $notification = "Mot de passe actuel incorrect";
        }

        $reponse = array(
            "success" => $success,
            "message" => $notification
        );

        return json_encode($reponse);

    }

    public function retirer_de_largent_waribank(Request $request,$id_menbre_connecter)
    {
        $success = false;
        $donnees_formulaire = $request->input();
        $mdp = $donnees_formulaire['mot_de_passe_actuel'];
        $montant_retrait = $donnees_formulaire['montant_retrait'];
        $mdp_md5 = md5($mdp);

        $utlisateur_existe = Menbre::where('id','=',$id_menbre_connecter)->where('mot_de_passe','=',$mdp_md5)->first();

        if($utlisateur_existe){
            $le_menbre = Menbre::find($id_menbre_connecter);

            //est qu'il dispose de cette somme sur son compte
            if($le_menbre->compte->solde < $montant_retrait){
                $notification = "VOUS NE DISPOSEZ PAS DE CE MONTANT.";
                
                $reponse = array(
                    "success" => $success,
                    "message" => $notification
                );
                return json_encode($reponse);
            }
              
        // CONVERSION EN CFA AVANT TRANSFERT
            $le_montant = $montant_retrait;
            $monaie_utilisateur = $le_menbre->devise_choisie->code;
            $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion($monaie_utilisateur,"XOF");
            $le_montant_en_xof = $quotient_de_conversion * $le_montant;
           
        // CONVERSION EN CFA AVANT TRANSFERT

            $response = \App\Http\Controllers\CinetpayApiTransfertController::effectuer_un_retrait($le_menbre,$le_montant_en_xof);
            $reponse_decoder = json_decode($response);
            $code = $reponse_decoder->code;
            $message = $reponse_decoder->message;
            
            
            if($code == 0){ // 0 = succes , les autres = prbleme
                $success = true;
                $notification = "votre retrait de $montant_retrait $monaie_utilisateur a bien ??t?? prise en compte et sera bien effectu??.";
                \App\Http\Controllers\CinetpayApiTransfertController::enregistrer_retrait($le_menbre,$montant_retrait);
                $monaie = $le_menbre->devise_choisie->monaie;
                
                
               $headers = 'From: waribana@waribana.net' . "\r\n" .
                 'Reply-To: no-reply@waribana.net' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();
                
                $message_sms = "Bonjour $le_menbre->nom_complet, votre retrait de $montant_retrait $monaie a bien ??t?? prise en compte et sera bien effectu??.";
                mail($le_menbre->email,'RETRAIT EFFECTUER',$message_sms,$headers);
                $numero = $le_menbre->telephone;
                SmsController::sms_info_bip("$numero",$message_sms);
            }else{
                $notification = "Echec de retrait, motif : $message ";
                
                if($message == 'INSUFFICIENT_BALANCE' ){
                    $notification = "Impossible d'effectu?? le retrait de ce montant ($le_montant $monaie_utilisateur) pour le moment, veuillez r????ssayer plus tard.";
                }
            }
            // return redirect()->back()->with('notification',$notification);
        }else{
            $notification = " Mot de passe Incorrect";
        };
        
        $reponse = array(
            "success" => $success,
            "message" => $notification
        );
        return json_encode($reponse);

    }


    public function paiement_cotisation($id_tontine,$id_menbre_connecter)
    {
        
        $le_menbre = Menbre::find($id_menbre_connecter);
        $la_tontine = Tontine::find($id_tontine);
        $montant = $la_tontine->montant;

        // CONVERSION EN CFA AVANT PAIEMENT
            if($le_menbre->devise_choisie->code != $la_tontine->createur->devise_choisie->code){
                $monaie_utilisateur = $le_menbre->devise_choisie->code;
                $monaie_createur_tontine =  $la_tontine->createur->devise_choisie->code;
                $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion(
                    $monaie_createur_tontine,$monaie_utilisateur);
                $le_montant_en_monaie_utilisateur_connecter = $quotient_de_conversion * $montant;
            }else{
                $le_montant_en_monaie_utilisateur_connecter = $montant;
            }
        // CONVERSION EN CFA AVANT PAIEMENT


        $success = false;
        // verif portefeuille
        if($le_menbre->compte->solde < $le_montant_en_monaie_utilisateur_connecter){
            $notification = "Votre solde est insuffisant.";
            $reponse = array(
                "success" => $success,
                "message" => $notification
            );

            return $reponse;
        }

        
        $la_transaction = new Transaction();
        $la_transaction->id_tontine = $id_tontine;
        $la_transaction->id_menbre = $id_menbre_connecter;
        $la_transaction->montant = $montant;
        $la_transaction->statut = "ACCEPTED";
        $la_transaction->id_menbre_qui_prend = $la_tontine->caisse->menbre_qui_prend->id;
        $la_transaction->index_ouverture = $la_tontine->caisse->index_ouverture;

        $notification = "Quelque chose s'est mal pass??, veuillez reessayez";
        if($la_transaction->save()){
            $la_caisse_de_la_tontine = CaisseTontine::findOrNew($id_tontine);
            $la_caisse_de_la_tontine->id_tontine= $id_tontine;
            $nouveau_montant = $la_caisse_de_la_tontine->montant;
            $nouveau_montant += $montant;
            $la_caisse_de_la_tontine->montant = $nouveau_montant;

            if($la_caisse_de_la_tontine->save()){
                $notification = "le paiement de votre cotisation bien effectu??e";

                //retirer le montant de la cotisation
                $le_portfeuille = $le_menbre->compte;
                $le_portfeuille->solde = $le_portfeuille->solde - $le_montant_en_monaie_utilisateur_connecter;
                $le_portfeuille->save();
            }

            $maintenant = date('d/m/Y H:i', strtotime(now()));
        //            dd($maintenant);
            $liste_participants = $la_tontine->participants;
        //            dd($liste_participants);
            $this->notifier_paiement_cotisation($liste_participants,$le_menbre->nom_complet,$montant,
            $la_tontine->createur->devise_choisie->monaie,$la_tontine->titre,$maintenant);

            if($le_menbre->email !=null){
                $infos_pour_recu = ['nom_complet'=>$le_menbre->nom_complet,
                    "email_destinataire"=>$le_menbre->email,
                    'type_section'=>'tontine',
                    'montant'=>$la_tontine->montant,
                    'titre_tontine'=>$la_tontine->titre,
                    'nom_menbre_qui_prend'=>$la_tontine->caisse->menbre_qui_prend->nom_complet];

                $this->recu_de_paiement_tontine($infos_pour_recu);
            }

            //===================Montant atteinds
            if($nouveau_montant == $la_caisse_de_la_tontine->montant_objectif){
                $index_menbre_qui_prend = $la_caisse_de_la_tontine->index_menbre_qui_prend;
                $nouvel_index = $index_menbre_qui_prend + 1;


                $montant_a_verser = $la_caisse_de_la_tontine->montant_a_verser;

        //===================Virer l'argent sur son compte et le noter dans le cahier
                $id_menbre_qui_prend = $la_caisse_de_la_tontine->id_menbre_qui_prend;


                // CONVERSION EN CFA AVANT PAIEMENT
                $le_menbre_qui_prend = Menbre::find($id_menbre_qui_prend);
                if($le_menbre_qui_prend->devise_choisie->code != $la_tontine->createur->devise_choisie->code){
                    $monaie_menbre_qui_prend = $le_menbre_qui_prend->devise_choisie->code;
                    $monaie_createur_tontine =  $la_tontine->createur->devise_choisie->code;
                    
                    $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion(
                        $monaie_createur_tontine,$monaie_menbre_qui_prend);

                    $montant_a_verser_en_monaie_menbre_qui_prend = $quotient_de_conversion * $montant_a_verser;
                }else{
                    $montant_a_verser_en_monaie_menbre_qui_prend = $montant_a_verser;
                }
            // CONVERSION EN CFA AVANT PAIEMENT
                $le_compte = CompteMenbre::findOrNew($id_menbre_qui_prend);
                $le_compte->id_menbre = $id_menbre_qui_prend;
                $le_solde = $le_compte->solde;
                $nouveau_solde = $le_solde + $montant_a_verser_en_monaie_menbre_qui_prend;
                $le_compte->solde = $nouveau_solde;

                //noter le virement dans le cahier comptable
                if($le_compte->save()){
                    $nouvelle_note = new CahierCompteTontine();
                    $nouvelle_note->id_menbre = $id_menbre_qui_prend;
                    $nouvelle_note->id_tontine = $id_tontine;
                    $nouvelle_note->montant = $montant_a_verser;
                    $nouvelle_note->index_ouverture = $la_tontine->caisse->index_ouverture;
                    $nouvelle_note->save();
                }

                $les_participants = $la_tontine->participants;
                foreach ($les_participants as $item_participant){

                    $titre_tontine = $la_tontine->titre;
                    $base_message = SmsContenuNotification::first();
                    $message = $base_message['virement_compte_menbre_qui_prend'];
                    $message = str_replace('$nom_menbre_qui_prend$',$la_tontine->caisse->menbre_qui_prend->nom_complet,$message);
                    $message = str_replace('$titre_tontine$',$titre_tontine,$message);
                    
                  $headers = 'From: waribana@waribana.net' . "\r\n" .
                 'Reply-To: no-reply@waribana.net' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();

                    $numero = $item_participant->telephone;
                    SmsController::sms_info_bip($numero,$message);
                    mail($item_participant->email,"$titre_tontine : MONTANT OBJECTIF DE COTISATION ATTEINDS",$message,$headers);

                }
        //====================Rotation
                //SI ON EST PAS AU DERNIER PARTICIPANTS
                if($nouvel_index < sizeof($la_tontine->participants)){
                    $liste_participant = $la_tontine->participants->toArray();
                    $nouvel_id_menbre_qui_prend = $liste_participant[$nouvel_index]['id'];

                    $date_encaissement = $la_caisse_de_la_tontine->prochaine_date_encaissement;
                    $nombre_de_jours_en_plus = $la_tontine->frequence_depot_en_jours;
                    $prochaine_date_encaissement = date('d-m-Y', strtotime($date_encaissement. " + $nombre_de_jours_en_plus days"));

                    $la_caisse_de_la_tontine->index_menbre_qui_prend = $nouvel_index;
                    $la_caisse_de_la_tontine->id_menbre_qui_prend = $nouvel_id_menbre_qui_prend;
                    $la_caisse_de_la_tontine->prochaine_date_encaissement = $prochaine_date_encaissement;
                    $la_caisse_de_la_tontine->montant = 0;
                    $la_caisse_de_la_tontine->save();
                }
                else{
                    $la_caisse_de_la_tontine->montant = 0;
                    $la_caisse_de_la_tontine->save();

                    $la_tontine->etat = 'terminer';
                    $la_tontine->save();
                    $success = true;
                    $notification = "Operation bien effectu??e, La tontine est complete (Terminer)";
                }

            }

        }
            
                $reponse = array(
                    "success" => $success,
                    "message" => $notification
                );

                return $reponse;
    }
    //================INVITATIONS

    public function adhesion_via_code_invitation($code_invitation,$id_menbre)
    {


        $la_tontine = Tontine::where('identifiant_adhesion','=',$code_invitation)->first();
        $success = false;
        // dd($la_tontine->titre);
        if($la_tontine ==null){
            $message = "Ce code est invalide";
        }else{

            $id_menbre_connecter = $id_menbre;

            $deja_menbre = MenbreTontine::where('menbre_id','=',$id_menbre_connecter)->where('tontine_id','=',$la_tontine->id)->first();
            if($deja_menbre==null){
                if(sizeof($la_tontine->participants) < $la_tontine->nombre_participant){

                    $nouveau_menbre = new MenbreTontine();
                    $nouveau_menbre->tontine_id = $la_tontine->id;
                    $nouveau_menbre->menbre_id = $id_menbre_connecter;
                    $nouveau_menbre->save();

                    $message = "Vous avez rejoins la tontine << $la_tontine->titre >>";
                    $success = true;

                    $la_tontine = Tontine::where('identifiant_adhesion','=',$code_invitation)->first();
                    if(sizeof($la_tontine->participants) == $la_tontine->nombre_participant){
                        Invitation::where('id_tontine','=',$la_tontine->id)->where('etat','=','attente')->update(['etat'=>"expiree"]);
                        $la_tontine->etat = 'prete';
                        $la_tontine->save();

                        $telephone = $la_tontine->createur->telephone;
                        $contenu_notification = SmsContenuNotification::first();
                        $message_notif = $contenu_notification['etat_tontine'];

                        $le_message = str_replace('$etat$',"prete",$message_notif);
                        $le_message = str_replace('$titre$',$la_tontine->titre,$le_message);
                        $le_message = str_replace('$motif$',"",$le_message);

                        SmsController::sms_info_bip($telephone,$le_message);
                    }
                }else{
                    $message = "Le nombre de participant est dej?? atteint";
                }

            }else{
                $message = "Vous ??tes deja un menbre de cette tontine";
            }
        }
        
        $reponse = array(
            "success" => $success,
            "message" => $message,
        );
        return json_encode($reponse);
    }

    
    public function envoyer_invitation_via_sms(Request $request,$id_tontine,$id_menbre_connecter)
    {
        $donnees_formulaire = $request->all();
        $telephone = $donnees_formulaire['telephone'];
        $le_numero = $telephone;

        $le_menbre = Menbre::find($id_menbre_connecter);
        $nom_complet = $le_menbre->nom_complet;

        $la_tontine = Tontine::find($id_tontine);
        $titre = $la_tontine->titre;
        $code_adhesion = $la_tontine->identifiant_adhesion;

        $adresse =  "https://" . $_SERVER['SERVER_NAME'] .'/espace-menbre/invitations';
        $message = " Bonjour, le menbre $nom_complet de waribana vous invite a rejoindre la tontine <<$titre>>,Connectez vous inscrivez-vous pour repondre a son invitation;
            Code d'adhesion : $code_adhesion.
            $adresse";
        
        $reponse = SmsController::sms_info_bip($le_numero,$message);
        
        $une_invitation = new Invitation();
        $une_invitation->id_tontine = $id_tontine;
        $une_invitation->email_inviter = $le_numero;
        $une_invitation->menbre_qui_invite = $id_menbre_connecter;
        $une_invitation->etat = "invitation envoyee";
        $une_invitation->save();
        $notification = "Invitations bien envoyee";
        
        return json_encode(
            array(
                "success" => true,
                "message" => $notification
            )
        );
    }

    public function envoyer_invitation_via_email(Request $request,$id_tontine,$id_menbre_connecter)
    {
        $donnees_formulaire = $request->all();

        $adresse =  "https://" . $_SERVER['SERVER_NAME'] .'/espace-menbre/invitations';

        $le_menbre = Menbre::find($id_menbre_connecter);
        $nom_complet = $le_menbre->nom_complet;

        $la_tontine = Tontine::find($id_tontine);
        $titre = $la_tontine->titre;
        $code_adhesion = $la_tontine->identifiant_adhesion;
        $liste_emails = explode(',',strtolower($donnees_formulaire['liste_emails']));
        $emails_to_string = implode(",",$liste_emails);
        $headers = 'From: waribana@waribana.net' . "\r\n" .
                 'Reply-To: no-reply@waribana.net' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();
        mail($emails_to_string,
            "REJOINS LA TONTINE $titre",
            "
                        Bonjour, le menbre $nom_complet de waribana vous invite a rejoindre la tontine <<$titre>>,
                        Connectez vous inscrivez-vous pour repondre a son invitation;
                        Code d'adhesion : $code_adhesion.
                        $adresse
            ",$headers
        );


        foreach ($liste_emails as $mail_item){
            $invitation_existante = Invitation::where('email_inviter','=',$mail_item)->where('id_tontine','=',$id_tontine)->first();

            if($invitation_existante ==null){
                $une_invitation = new Invitation();
                $une_invitation->id_tontine = $id_tontine;
                $une_invitation->email_inviter = $mail_item;
                $une_invitation->menbre_qui_invite = $id_menbre_connecter;
                $une_invitation->save();
            }
        }

        $notification = "Invitations bien envoyee";
        
        return json_encode(
            array(
                "success" => true,
                "message" => $notification
            )
        );
    }

        
    public function invitations_recues($id_menbre_connecter)
    {
        $le_menbre = Menbre::find($id_menbre_connecter);
        $email_inviter = $le_menbre['email'];
        $telephone_inviter = $le_menbre['telephone'];

        $invitations_recues = [];
        if($email_inviter!=null){
            $invitations_recues = Invitation::with('tontine')
            ->with('menbre_inviteur')->where('email_inviter','=',$email_inviter)->where('etat','=','attente')->orWhere('email_inviter','=',$telephone_inviter)->where('etat','=','invitation envoyee')->get();
        }

        return json_encode($invitations_recues);
    }

    public function repondre_a_une_invitation($id_invitation,$id_menbre_connecter,$reponse)
    {
    
            $linvitation = Invitation::find($id_invitation);
    
            $la_tontine = $linvitation->tontine;

            $success = true;
            $message = "quelque chose s'est mal pass??";

            if(sizeof($la_tontine->participants) < $la_tontine->nombre_participant){
                $linvitation->etat = $reponse;
                $linvitation->save();
                
                $message = "Invitation refusee";
    
                if($reponse == 'acceptee'){
                    $message = "Invitation acceptee";
    
                    $deja_menbre = MenbreTontine::where('menbre_id','=',$id_menbre_connecter)->where('tontine_id','=',$la_tontine->id)->first();
                    if($deja_menbre==null){
                        $nouveau_menbre = new MenbreTontine();
                        $nouveau_menbre->tontine_id = $la_tontine->id;
                        $nouveau_menbre->menbre_id = $id_menbre_connecter;
                        $nouveau_menbre->save();
                    }
                }
    
                $id_tontine = $la_tontine['id'];
                $la_tontine = Tontine::find($id_tontine);
    
                //NOMBRE DE PARTICPANT ATTEINDS, LA TONTINE EST PRETE
                if(sizeof($la_tontine->participants) == $la_tontine->nombre_participant){
                    Invitation::where('id_tontine','=',$la_tontine->id)->where('etat','=','attente')->update(['etat'=>"expiree"]);
                    $la_tontine->etat = 'prete';
                    $la_tontine->save();
    
    
                    $telephone = $la_tontine->createur->telephone;
                    $contenu_notification = SmsContenuNotification::first();
                    $message_notif = $contenu_notification['etat_tontine'];
    
                    $le_message = str_replace('$etat$',"prete",$message_notif);
                    $le_message = str_replace('$titre$',$la_tontine->titre,$le_message);
                    $le_message = str_replace('$motif$',"",$le_message);
    
                    SmsController::sms_info_bip($telephone,$le_message);
                }
            }else{
                Invitation::where('id_tontine','=',$la_tontine->id)->where('etat','=','attente')->update(['etat'=>"expiree"]);
    
                if($reponse == 'acceptee') {
                    $success = false;
                    $message  = "Le nombre de participant est dej?? atteint";
                }
            }
    
            $reponse = array(
                "success" => $success,
                "message" => $message,
            );
            return json_encode($reponse);
    }

////===================WARICROWDS=========================

public function liste_waricrowd_dutilisateur($id_menbre)
{ //les tontines de l'utilisateur connecter
    $le_menbre = Menbre::find($id_menbre);

    $mes_waricrowd = $le_menbre->mes_waricrowd_pour_mobile;
    return json_encode($mes_waricrowd);
}

public function liste_projet_soutenus($id_menbre)
{ //les tontines de l'utilisateur connecter
    $le_menbre = Menbre::find($id_menbre);

    $projets_soutenus_pour_mobile = $le_menbre->projets_soutenus_pour_mobile;
    return json_encode($projets_soutenus_pour_mobile);
}

public function liste_categorie_crowd()
{
    $liste_categorie_crowd = CategorieWaricrowd::all();
    return json_encode($liste_categorie_crowd);
}

public function details_waricrowd($id_crowd,$id_menbre)
{
    if($id_menbre !=null){ //quand c'est un crowd qui appartient au menbre
        $details_crowd = Waricrowd::with("categorie")->with("createur")->with("transactions")->with("caisse")
        ->where("id","=",$id_crowd)->first();

        $nombre_transaction_generale = TransactionWaricrowd::where('id_waricrowd','=',$id_crowd)->count();

        $transaction_du_menbre = TransactionWaricrowd::where('id_menbre','=',$id_menbre)->where('id_waricrowd','=',$id_crowd)->with('souteneur')->get();
        $details_crowd["mes_transactions"] = $transaction_du_menbre;
        $details_crowd['nombre_transaction_generale'] = $nombre_transaction_generale;
    }
    
    return json_encode($details_crowd);
}

public function enregistrer_un_waricrowd(Request $request,$id_menbre_connecter)
{
    $donnees_formulaire = $request->all();
    $id_categorie_waricrowd = $donnees_formulaire['id_categorie_waricrowd'];
    $titre = $donnees_formulaire['titre'];
    $description_courte = $donnees_formulaire['description_courte'];
    $description_complete = $donnees_formulaire['description_complete'];
    $montant_objectif = $donnees_formulaire['montant_objectif'];
    $pitch_video = $this->formaterLienPitch($donnees_formulaire['lien_pitch_video']);

    if( empty($id_categorie_waricrowd)  || empty($titre)  || empty($description_courte)  || empty($description_complete)  || empty($montant_objectif) ){
        return json_encode(
            array(
                "success" => false,
                "message" => "Tous les champs avec (*) devant sont obligatoires",
            )
        );
    }

    $le_crowd = new Waricrowd();
    $le_crowd->id_categorie = $id_categorie_waricrowd;
    $le_crowd->id_menbre = $id_menbre_connecter;
    $le_crowd->titre = $titre;
    $le_crowd->description_courte = $description_courte;
    $le_crowd->description_complete = $description_complete;
    $le_crowd->montant_objectif = $montant_objectif;
    $le_crowd->lien_pitch_video = $pitch_video;

    $nom_image_illustration=null;
    if($request->hasFile('image_illustration')){
        $uploaddir = public_path('images/waricrowd/');
        $nom_image_illustration = 'images/waricrowd/'. basename($_FILES['image_illustration']['name']);
        move_uploaded_file($_FILES['image_illustration']['tmp_name'], $nom_image_illustration);

        $le_crowd->image_illustration = $nom_image_illustration;
    }

    if($le_crowd->save()){
        //creer la caisse qui va avec
        $la_caisse_de_crowd = CaisseWaricrowd::findOrNew($le_crowd->id);
        $la_caisse_de_crowd->id_waricrowd = $le_crowd->id;
        $la_caisse_de_crowd->montant_objectif = $montant_objectif;
        $la_caisse_de_crowd->montant = 0;
        $la_caisse_de_crowd->save();

        $route = route('espace_menbre.details_waricrowd',[$le_crowd->id]);

        $success = true;
        $notification = "Operation effectu??e avec succes ";
    }else{
        $success = false;
        $notification = "Quelquechose s'est mal pass??e, veuillez r????ssayer";
    }

    return json_encode(
        array(
            "success" => $success,
            "id_crowd" => $le_crowd->id,
            "message" => $notification,
        )
    );
}

public function paiement_soutien_waricrowd(Request $request,$id_crowd,$id_menbre_connecter)
{
   
    $success = false;
    $donnees_formulaire = $request->all();

    $donnees_formulaire = $request->all();
    $montant_soutien = $donnees_formulaire['montant_soutien'];

    $le_menbre = Menbre::find($id_menbre_connecter);
    $le_crowd = Waricrowd::find($id_crowd);

    // CONVERSION EN CFA AVANT PAIEMENT
        if($le_menbre->devise_choisie->code != $le_crowd->createur->devise_choisie->code){
            $monaie_utilisateur = $le_menbre->devise_choisie->code;
            $monaie_createur_crowd =  $le_crowd->createur->devise_choisie->code;
            $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion(
                $monaie_createur_crowd,$monaie_utilisateur);
            $le_montant_en_monaie_utilisateur_connecter = $quotient_de_conversion * $montant_soutien;
        }else{
            $le_montant_en_monaie_utilisateur_connecter = $montant_soutien;
        }
    // CONVERSION EN CFA AVANT PAIEMENT


    // verif portefeuille
    $le_menbre = Menbre::find($id_menbre_connecter);
    if($le_menbre->compte->solde < $le_montant_en_monaie_utilisateur_connecter){
        $notification = "Votre solde est insuffisant.";
        
        $reponse = array(
            "success" => $success,
            "message" => $notification
        );

        return $reponse;
    }


    $la_transaction = new TransactionWaricrowd();
    $la_transaction->id_menbre = $id_menbre_connecter;
    $la_transaction->id_waricrowd = $id_crowd;
    $la_transaction->statut = "ACCEPTED";
    $la_transaction->montant = $montant_soutien;

    if($la_transaction->save()){
        $la_caisse = CaisseWaricrowd::findOrNew($id_crowd);
    //            $la_caisse->id_waricrowd = $id_crowd;
        $ancien_montant = $la_caisse->montant;
        $nouveau_montant = $ancien_montant + $montant_soutien;
        $la_caisse->montant = $nouveau_montant;
        $la_caisse->save();

        //enregistrer
        $menbre_souteneur = WaricrowdMenbre::firstOrNew(['menbre_id'=>$id_menbre_connecter,'waricrowd_id'=>$id_crowd]);
        $menbre_souteneur->menbre_id = $id_menbre_connecter;
        $menbre_souteneur->waricrowd_id = $id_crowd;
        $menbre_souteneur->save();

        $notification = "Votre paiement a bien effectu??, soutien enregistr??.";

        
        //retirer le montant du soutien
        $le_portfeuille = $le_menbre->compte;
        $le_portfeuille->solde = $le_portfeuille->solde - $le_montant_en_monaie_utilisateur_connecter;
        $le_portfeuille->save();

        $infos_pour_recu = [
            'nom_complet'=>$le_menbre->nom_complet,
            'email_souteneur'=>$le_menbre->email,
            'type_section'=>'tontine',
            'montant'=>$montant_soutien,
            'titre_waricrowd'=>$le_crowd->titre,
            'nom_createur_waricrowd'=>$le_crowd->createur->nom_complet];
        $this->recu_de_paiement_waricrowd($infos_pour_recu);

        $date_paiement = date('d/m/Y H:i');
        $this->notifier_paiement_sms($le_menbre->telephone,$le_menbre->nom_complet,$montant_soutien,$le_crowd->createur->devise_choisie->monaie,$le_crowd->titre,$date_paiement);
        $this->notifier_paiement_sms($le_crowd ->telephone,$le_menbre->nom_complet,$montant_soutien,$le_crowd->createur->devise_choisie->monaie,$le_crowd->titre,$date_paiement);
        $success = true;
    }else{
        $notification = "Quelque chose s'est mal pass?? ";
    }

    $reponse = array(
        "success" => $success,
        "message" => $notification
    );

    return $reponse;
}

public function modifier_un_waricrowd(Request $request,$id_crowd,$id_menbre_connecter)
{
    $donnees_formulaire = $request->all();

    $id_categorie_waricrowd = $donnees_formulaire['id_categorie_waricrowd'];
    $titre = $donnees_formulaire['titre'];
    $description_courte = $donnees_formulaire['description_courte'];
    $description_complete = $donnees_formulaire['description_complete'];
    $montant_objectif = $donnees_formulaire['montant_objectif'];
    $pitch_video = $this->formaterLienPitch($donnees_formulaire['lien_pitch_video']);

    if( empty($id_categorie_waricrowd)  || empty($titre)  || empty($description_courte)  || empty($description_complete)  || empty($montant_objectif) ){
        return json_encode(
            array(
                "success" => false,
                "message" => "Tous les champs avec (*) devant sont obligatoires",
            )
        );
    }

    $le_crowd = Waricrowd::find($id_crowd);

    if(sizeof($le_crowd->transactions) > 0 ){
        return json_encode(
            array(
                "success" => false,
                "message" => "Vous ne pouvez pas modifier un crowd apres que des transactions ai ??t?? effectu??es",
            )
        );
    }

    $le_crowd->id_categorie = $id_categorie_waricrowd;
    $le_crowd->id_menbre = $id_menbre_connecter;
    $le_crowd->titre = $titre;
    $le_crowd->description_courte = $description_courte;
    $le_crowd->description_complete = $description_complete;
    $le_crowd->montant_objectif = $montant_objectif;
    if(!empty($pitch_video)){
        $le_crowd->lien_pitch_video = $pitch_video;
    }

    $nom_image_illustration=null;
    if($request->hasFile('image_illustration')){
        $uploaddir = public_path('images/waricrowd/');
        $nom_image_illustration = 'images/waricrowd/'. basename($_FILES['image_illustration']['name']);
        move_uploaded_file($_FILES['image_illustration']['tmp_name'], $nom_image_illustration);

        $le_crowd->image_illustration = $nom_image_illustration;
    }

    if($le_crowd->save()){
        //creer la caisse qui va avec
        $la_caisse_de_crowd = CaisseWaricrowd::findOrNew($le_crowd->id);
        $la_caisse_de_crowd->id_waricrowd = $le_crowd->id;
        $la_caisse_de_crowd->montant_objectif = $montant_objectif;
        $la_caisse_de_crowd->save();

        $success = true;
        $notification = "Operation effectu??e avec succes";
    }else{
        $success = false;
        $notification = "Quelquechose s'est mal pass??e, veuillez reessayer";
    }

  
    return json_encode(
        array(
            "success" => $success,
            "message" => $notification,
        )
    );
}



public function supprimer_waricrowd(Request $request,$id_crowd,$id_menbre)
{
    $le_crowd = Waricrowd::find($id_crowd);
        //        dd($le_crowd->transactions);
    if(sizeof($le_crowd->transactions) == 0 && $le_crowd->id_menbre == $id_menbre ){
        $le_crowd->delete();
        $success = true;
        $notification = "Operation bien effectu??e";
    }else{
        $success = false;
        $notification = "Vous ne pouvez pas supprimer un waricrowd apres que des transactions ai ??t?? effectu??es";
    }
    
  
    return json_encode(
        array(
            "success" => $success,
            "message" => $notification,
        )
    );
}





////===================UTILITAIRES=========================
    private function creer_session_menbre($reponse,$le_menbre)
    {
        $id_menbre = $le_menbre->id;
        $nom_complet = $le_menbre->nom_complet;
        $email = $le_menbre->email;
        $telephone = $le_menbre->telephone;
        if($le_menbre->devise_choisie !=null){
            $devise = $le_menbre->devise_choisie->monaie;
            $code_devise = $le_menbre->devise_choisie->code;
        }else{
            $devise = null;
            $code_devise = null;
        }
        
        $reponse['utilisateur'] = ['id' => $id_menbre,
         'nom_complet' => $nom_complet,
          'devise' => $devise,
          'code_devise'=>$code_devise,
          'email'=>$email,
          'telephone'=>$telephone,
        ];
        return $reponse;
    }

    private function checkExistenceEmail($email)
    {
        $menbre_existant = Menbre::where('email', '=', $email)->first();
        if ($menbre_existant != null) {
            return true;
        } else {
            return false;
        }
    }

    private function checkExistenceEmailPourAutrePersonne($email,$id_menbre)
    {
        $menbre_existant = Menbre::where('email','=',$email)->where('id','!=',$id_menbre)->first();
        if($menbre_existant != null){
            return true;
        }else{
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


    private function checkExistenceNumeroPourAutrePersonne($numero,$id_menbre)
    {
        $menbre_existant = Menbre::where('telephone','=',$numero)->where('id','!=',$id_menbre)->first();
        if($menbre_existant != null){
            return true;
        }else{
            return false;
        }
    }

    private function VerifieLeMotDePasse($mdp,$id_menbre)
    {
        $mdp_cacher = md5($mdp);
        $menbre_existant = Menbre::where('mot_de_passe','=',$mdp_cacher)->where('id','=',$id_menbre)->first();
        if($menbre_existant != null){
            return true;
        }else{
            return false;
        }
    }

    public  function formaterLienPitch($lien_pitch)
    {
        $lien_pour_integration =null;
        // bon format = https://www.youtube.com/embed/bethOeuIkWI
        $tableau = explode('watch?v=',$lien_pitch);
        $copier_dans_la_barre_dadresse = sizeof($tableau)==2;
        if($copier_dans_la_barre_dadresse) {
            $lien_pour_integration = str_replace('watch?v=', 'embed/', $lien_pitch);
        }else{
        //            https://youtu.be/DzH5aRoMYLw
            if(str_contains($lien_pitch,'youtu.be')){
                $tableau = explode('youtu.be/',"$lien_pitch");
        //                dd($tableau);
                $id_video = $tableau[1];
                $lien_pour_integration = "https://www.youtube.com/embed/$id_video";
            }
        }
        return $lien_pour_integration;
    }

    
    private function notifier_paiement_sms($numeropayeur,$nom_payeur,$montant_soutien,$devise,$titre_du_waricrowd,$date_paiement){
        $numeropayeur = $numeropayeur;
           $message_sms = "Soutien a hauteur de $montant_soutien $devise par $nom_payeur sur waricrowd << $titre_du_waricrowd >> le $date_paiement ";
           SmsController::sms_info_bip("$numeropayeur",$message_sms);
   }

   
   public function recu_de_paiement_waricrowd($infos_pour_recu){
    $pdf = PDF::loadView('espace_menbre/recu_paiement_waricrowd',compact('infos_pour_recu'));
    $nom_fichier = time().'.pdf';
    Storage::put("public/recu/waricrowd/$nom_fichier", $pdf->output());

    $email = $infos_pour_recu['email_souteneur'];
    $message = "Felicitations, votre paiement a bien ete effectue, ci-joint votre recu de paiement.";
    $chemin_fichier = Storage::disk('public')->path("recu/waricrowd/".$nom_fichier);
    $this->envoyer_email_avec_fichier($email,"RECU DE PAIEMENT WARICROWD",$message,$chemin_fichier,$nom_fichier);

//        return $pdf->stream();
}

public static function envoyer_email_avec_fichier($destinaires,$sujet,$message,$chemin_fichier,$nom_fichier){
    $email = new PHPMailer();
    $email->SetFrom('no-reply@waribana.com', 'WARIBANA'); //Name is optional
    $email->Subject   = $sujet;
    $email->Body      = $message;
    $email->AddAddress( $destinaires );

    // dd($chemin_fichier);
    $email->AddAttachment($chemin_fichier, "$nom_fichier");

    return $email->Send();
}

public function recu_de_paiement_tontine($infos_pour_recu=null){
    if($infos_pour_recu==null){
        $infos_pour_recu = ['email_destinataire'=>'yvessantoz@gmail.com','nom_complet'=>'sh sdfds','montant'=>'232343','titre_tontine'=>'tontine ice','nom_menbre_qui_prend'=>'djsdh dskhdsjk'];
    }

    $pdf = PDF::loadView('espace_menbre/recu_paiement_tontine',compact('infos_pour_recu'));
    $nom_fichier = time().'.pdf';
    Storage::put("public/recu/tontines/$nom_fichier", $pdf->output());

    $email = $infos_pour_recu['email_destinataire'];
    $message = "Felicitations, votre paiement a bien ete effectue, ci-joint votre recu de paiement.";
    $chemin_fichier = Storage::disk('public')->path("recu/tontines/".$nom_fichier);

    $rep = EspaceMenbreWaricrowdController::envoyer_email_avec_fichier($email,"RECU DE PAIEMENT WARICROWD",$message,$chemin_fichier,$nom_fichier);
}

private function notifier_paiement_cotisation($liste_participants,$nom_cotiseur,$montant_cotisation,$devise,$titre_de_la_tontine,$date_paiement){
    foreach($liste_participants as $item_participant){
        $numero = "$item_participant->telephone";
        $message_sms = "Paiement de $montant_cotisation $devise par $nom_cotiseur sur la totine <<$titre_de_la_tontine>> le $date_paiement ";
        SmsController::sms_info_bip("$numero",$message_sms);
    }
}
    
}
