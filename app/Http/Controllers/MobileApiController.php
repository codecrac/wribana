<?php

namespace App\Http\Controllers;

use App\Models\Waricrowd;
use App\Models\Menbre;
use App\Models\Invitation;
use App\Models\Tontine;
use App\Models\MenbreTontine;
use App\Models\CaisseTontine;
use App\Models\Transaction;
use App\Models\CompteMenbre;
use App\Models\CategorieWaricrowd;
use App\Models\CaisseWaricrowd;
use App\Models\Devise;

use App\Http\Controllers\SmsController;
use App\Models\SmsContenuNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileApiController extends Controller
{

//===================VITRINE#VITRINE---#----VITRINE#VITRINE--------#----------VITRINE#VITRINE#VITRINE#VITRINE#VITRINE
    public function liste_crowd($index_pagination=0){
        $les_crowds = Waricrowd::where('etat','=','valider')->with('categorie')->with('createur')->with('caisse')->skip($index_pagination)->limit(25)->get();
        return $les_crowds;
        return json_encode($les_crowds);
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
                $message = "Cette adresse email est déja utilisée.";
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
        $message = "Votre profil a bien été mmodifié";

        
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
                    $message = "Modification du mot de passe effectuée ";
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


    public function modifier_telephone_compte(Request $request,$id_menbre_connecter)
    {
        //nouveau code
        $code_de_confirmation = rand(1111, 9999) * 12;
        $le_menbre->code_de_confirmation = $code_de_confirmation;
        $le_menbre->save();

        $notification = "Numero Invalide";
        $donnees_formulaire = $request->all();
        $telephone = $donnees_formulaire['nouveau_telephone'];
        if (is_numeric($telephone)) {
            if (!($this->checkExistenceNumeroPourAutrePersonne($telephone,$id_menbre_connecter))) {
                $le_numero = $telephone;
                $code = $code_de_confirmation;
                $contenu_notification = SmsContenuNotification::first();
                $message_confirmation = $contenu_notification['confirmation_compte'];
                $le_message = str_replace('$code$',$code,$message_confirmation);
                SmsController::sms_info_bip($le_numero, $le_message);

                $reponse = array(
                    "success" => true,
                    "message" => "un message de confirmation vous a été envoyé",
                );
            }else{
              $reponse = array(
                "success" => false,
                "message" => "Ce numero a deja été utilisé",
            );
            }
        } else {
              $reponse = array(
                        "success" => false,
                        "message" => "Numero Invalide",
                    );
        };
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
                $message = "Cette adresse email est déja utilisée.";
                $reponse = array(
                    "success" => false,
                    "message" => $message,
                );
                return $reponse;
            }
        }
        $telephone_existe_deja = $this->checkExistenceNumero($numero);
        if ($telephone_existe_deja) {
            $message = "Ce numero ($numero) de telephone a déja utilisé.";
            
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
                $message = "Inscription éffectuée, connectez-vous";
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
        $le_menbre = Menbre::find($id_menbre);
        $le_menbre['devise'] = $le_menbre->devise_choisie->monaie;
        $le_menbre['code_devise'] = $le_menbre->devise_choisie->code;
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
                        "message" => "Un code de confirmation vous a ete envoyé",
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
                "message" => "code invalide, rééssayez",
            );
        }
        
        return json_encode($reponse);
    }

    public function reinitialiser_mot_de_passe($identifiant)
    {

        $notification = "Un message de recuperation de compte vous été envoyer par sms et par email";
        $le_menbre = Menbre::where('telephone','=',$identifiant)->orWhere('email','=',$identifiant)->first();
        //        dd($le_menbre);
        if($le_menbre != null){
            $nouveau_mdp = intdiv( time() ,99) * rand(1111,9999) ;
            $mdp_cacher = md5($nouveau_mdp);

            $telephone = $le_menbre->telephone;
            $message = "Bonjour,votre mot de passe a bien été reinitialiser, utilisez le nouveau mot de passe pour vous connecter puis changez le.
            nouveau mot de passe : $nouveau_mdp ";
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
            $notification = "Ce identifiant n'est associé à aucun compte";
        }

        $reponse = array(
            "success" => true,
            "message" => $notification,
        );
        return $reponse;

    }

//===================espace MEMBRE#espace MEMBRE---#----espace MEMBRE#espace MEMBRE--------#----------°°°°°°°°°°°°°°
   
#===============TONTINE==========TONTINE==========TONTINE==========
    public function infos_pour_tableau_de_bord($id_menbre)
    {
        $le_menbre = Menbre::find($id_menbre);
        // dd($le_menbre);
        $email_inviter = $le_menbre->email;
        $invitation_recues = [];
        $nb_invitation_recues =0;
        if($email_inviter!=null){
            $nb_invitation_recues = Invitation::where('email_inviter','=',$email_inviter)->where('etat','=','attente')->count();
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

    public function details_profil_utilisateur($id_menbre){
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
                    $notification = "la tontine ($la_tontine->titre) a bien été créé";
                }else{
                    $notification = "Un probleme est survenu";
                }

            }else{
                $notification = "Echec de l'Operation, veuillez rééssayer";
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

    public function liste_tontine($id_menbre){ //les tontines de l'utilisateur connecter
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
                $message = "Operation bien éffectuée";
            }else{
                $message = "Echec de l'Operation, veuillez rééssayer";
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
                $notification = "Vous ne pouvez pas supprimer une tontine apres que des transactions ai été effectuées";
            }
        }
        
        return json_encode(
            array(
                "success" => $success,
                "message" => $notification,
            )
        );
    }

    public function ouvrir_tontine($id_tontine){
        
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
                

                $message = "La tontine a bien été ouverte ";
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

    public function paiement_cotisation($id_tontine,$id_menbre_connecter){
        //===================POUR PAIEMENT AVEC CINETPAY================================
                $la_tontine = Tontine::find($id_tontine);
        
                // CONVERSION EN CFA AVANT PAIEMENT
                    $le_montant = $la_tontine->montant;
                    if($la_tontine->createur->devise_choisie->code != "XOF"){
                        $monaie_createur_tontine = $la_tontine->createur->devise_choisie->code;
                        $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion($monaie_createur_tontine,"XOF");
                        $le_montant_en_xof = $quotient_de_conversion * $le_montant;
                    }else{
                        $le_montant_en_xof = $le_montant;
                    }
                // CONVERSION EN CFA AVANT PAIEMENT
        
                $le_menbre = Menbre::find($id_menbre_connecter);
                $route_back_en_cas_derreur = route('api.mobile.statut_transaction');
                $payment_url = CinetpayPaiementController::generer_lien_paiement($le_menbre,$id_tontine,$le_montant_en_xof,
                $le_montant,'tontine',$route_back_en_cas_derreur);
            

                $reponse = array(
                    "success" => true,
                    "url_paiement" => $payment_url,
                    "message" => $payment_url
                );

                return $reponse;
    }
    //================INVITATIONS

    public function adhesion_via_code_invitation($code_invitation,$id_menbre){


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
                    $message = "Le nombre de participant est dejà atteint";
                }

            }else{
                $message = "Vous êtes deja un menbre de cette tontine";
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

        // dd($le_numero);
        $reponse = SmsController::sms_info_bip($le_numero,$message);
        // dd($reponse);

        
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
        $headers = 'From: no-reply@waribana.net' . "\r\n" .
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

        $invitations_recues = [];
        if($email_inviter!=null){
            $invitations_recues = Invitation::where('email_inviter','=',$email_inviter)->with('tontine')->with('menbre_inviteur')->where('etat','=','attente')->get();
        }

        return json_encode($invitations_recues);
    }

    public function repondre_a_une_invitation($id_invitation,$id_menbre_connecter,$reponse)
    {
    
            $linvitation = Invitation::find($id_invitation);
    
            $la_tontine = $linvitation->tontine;

            $success = true;
            $message = "quelque chose s'est mal passé";

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
                    $message  = "Le nombre de participant est dejà atteint";
                }
            }
    
            $reponse = array(
                "success" => $success,
                "message" => $message,
            );
            return json_encode($reponse);
    }

////===================WARICROWDS=========================

public function liste_waricrowd_dutilisateur($id_menbre){ //les tontines de l'utilisateur connecter
    $le_menbre = Menbre::find($id_menbre);

    $mes_waricrowd = $le_menbre->mes_waricrowd_pour_mobile;
    return json_encode($mes_waricrowd);
}

public function liste_projet_soutenus($id_menbre){ //les tontines de l'utilisateur connecter
    $le_menbre = Menbre::find($id_menbre);

    $projets_soutenus_pour_mobile = $le_menbre->projets_soutenus_pour_mobile;
    return json_encode($projets_soutenus_pour_mobile);
}

public function liste_categorie_crowd(){
    $liste_categorie_crowd = CategorieWaricrowd::all();
    return json_encode($liste_categorie_crowd);
}

public function details_waricrowd($id_crowd,$id_menbre=null){
    if($id_menbre !=null){ //quand c'est un crowd qui appartient au menbre
        $liste_categorie_crowd = Waricrowd::with("categorie")->with("createur")->with("caisse")->
        with("transactions")->where("id","=",$id_crowd)->where("id_menbre","=",$id_menbre)->first();
    }
    else{ //quand c'est un projet soutenus
        $liste_categorie_crowd = Waricrowd::with("categorie")->with("createur")->with("caisse")->
        with("transactions")->where("id","=",$id_crowd)->first();
    }
    
    return json_encode($liste_categorie_crowd);
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
        $notification = "Operation effectuée avec succes ";
    }else{
        $success = false;
        $notification = "Quelquechose s'est mal passée, veuillez rééssayer";
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
   //================INTEGRATION CINETPAY===================
    $donnees_formulaire = $request->all();

    // CONVERSION EN CFA AVANT PAIEMENT
    $le_crowd = Waricrowd::find($id_crowd);
    $le_montant = $donnees_formulaire['montant_soutien'];


    if(empty($le_montant) || $le_montant == null ){
        $reponse = array(
            "success" => false,
            "url_paiement" => "",
            "message" => "Veuillez entrer un montant"
        );
        return $reponse;
    }

    if($le_crowd->createur->devise_choisie->code != "XOF"){
        $monaie_createur_tontine = $le_crowd->createur->devise_choisie->code;
        $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion($monaie_createur_tontine,"XOF");
        $le_montant_en_xof = $quotient_de_conversion * $le_montant;
    }else{
        $le_montant_en_xof = $le_montant;
    }
    // CONVERSION EN CFA AVANT PAIEMENT

    $le_menbre = Menbre::find($id_menbre_connecter);
    $route_back_en_cas_derreur = route('api.mobile.statut_transaction');
    $payment_url = CinetpayPaiementController::generer_lien_paiement($le_menbre,$id_crowd,$le_montant_en_xof,$le_montant
    ,'waricrowd',$route_back_en_cas_derreur);

    $reponse = array(
        "success" => true,
        "url_paiement" => $payment_url,
        "message" => $payment_url
    );

    return $reponse;
}

public function modifier_un_waricrowd(Request $request,$id_crowd,$id_menbre_connecter){
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
        $notification = "Operation effectuée avec succes";
    }else{
        $success = false;
        $notification = "Quelquechose s'est mal passée, veuillez reessayer";
    }

  
    return json_encode(
        array(
            "success" => $success,
            "message" => $notification,
        )
    );
}



public function supprimer_waricrowd(Request $request,$id_crowd,$id_menbre){
    $le_crowd = Waricrowd::find($id_crowd);
//        dd($le_crowd->transactions);
    if(sizeof($le_crowd->transactions) == 0 && $le_crowd->id_menbre == $id_menbre ){
        $le_crowd->delete();
        $success = true;
        $notification = "Operation bien effectuée";
    }else{
        $success = false;
        $notification = "Vous ne pouvez pas supprimer un waricrowd apres que des transactions ai été effectuées";
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

    private function checkExistenceEmailPourAutrePersonne($email,$id_menbre){
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


    private function checkExistenceNumeroPourAutrePersonne($numero,$id_menbre){
        $menbre_existant = Menbre::where('telephone','=',$numero)->where('id','!=',$id_menbre)->first();
        if($menbre_existant != null){
            return true;
        }else{
            return false;
        }
    }

    private function VerifieLeMotDePasse($mdp,$id_menbre){
        $mdp_cacher = md5($mdp);
        $menbre_existant = Menbre::where('mot_de_passe','=',$mdp_cacher)->where('id','=',$id_menbre)->first();
        if($menbre_existant != null){
            return true;
        }else{
            return false;
        }
    }
    public  function formaterLienPitch($lien_pitch){
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
    
}
