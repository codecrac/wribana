<?php

namespace App\Http\Controllers;

use App\Models\Waricrowd;
use App\Models\Menbre;
use App\Models\Invitation;
use App\Models\Tontine;
use App\Models\MenbreTontine;
use App\Models\CaisseTontine;
use App\Models\Transaction;

use App\Http\Controllers\SmsController;
use App\Models\SmsContenuNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileApiController extends Controller
{

//===================VITRINE#VITRINE---#----VITRINE#VITRINE--------#----------VITRINE#VITRINE#VITRINE#VITRINE#VITRINE
    public function liste_crowd($index_pagination=0){
        $les_crowds = Waricrowd::with('categorie')->with('createur')->with('caisse')->skip($index_pagination)->limit(25)->get();
        return $les_crowds;
        return json_encode($les_crowds);
    }

    public function connexion(Request $request){
        
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


//===================espace MEMBRE#espace MEMBRE---#----espace MEMBRE#espace MEMBRE--------#----------°°°°°°°°°°°°°°
   
#===============TONTINE==========TONTINE==========TONTINE==========
    public function infos_pour_tableau_de_bord($id_menbre){
        $le_menbre = Menbre::find($id_menbre);
        // dd($le_menbre);
        $email_inviter = $le_menbre->email;
        $invitation_recues = [];
        if($email_inviter!=null){
            $nb_invitation_recues = Invitation::where('email_inviter','=',$email_inviter)->where('etat','=','attente')->count();
        }

        $infos_pour_tableau_de_bord = [];
        $infos_pour_tableau_de_bord['nb_tontine'] = sizeof($le_menbre->tontines);
        $infos_pour_tableau_de_bord['nb_invitations_recues'] = $nb_invitation_recues;
        $infos_pour_tableau_de_bord['nb_waricrowd'] = sizeof($le_menbre->mes_waricrowd);
        $infos_pour_tableau_de_bord['nb_projets_soutenus'] = sizeof($le_menbre->projets_soutenus);
        $infos_pour_tableau_de_bord['solde'] = $le_menbre->compte->solde ." ". $le_menbre->devise_choisie->monaie;
        // return $infos_pour_tableau_de_bord;
        return json_encode($infos_pour_tableau_de_bord);
    }


    
    public function enregistrer_tontine(Request $request,$id_menbre_connecter){
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
    
    
    public function details_tontine($id_tontine,$id_menbre_connecter){


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

    public function modifier_tontine(Request $request,$id_tontine){
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
                $payment_url_ou_false = CinetpayPaiementController::generer_lien_paiement($le_menbre,$id_tontine,$le_montant_en_xof,$le_montant,'tontine',$route_back_en_cas_derreur);
            

                $reponse = array(
                    "success" => true,
                    "url_paiement" => $payment_url_ou_false,
                    "message" => $payment_url_ou_false
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

        
    public function invitations_recues($id_menbre_connecter){
        $le_menbre = Menbre::find($id_menbre_connecter);
        $email_inviter = $le_menbre['email'];

        $invitations_recues = [];
        if($email_inviter!=null){
            $invitations_recues = Invitation::where('email_inviter','=',$email_inviter)->with('tontine')->with('menbre_inviteur')->where('etat','=','attente')->get();
        }

        return json_encode($invitations_recues);
    }

    public function repondre_a_une_invitation($id_invitation,$id_menbre_connecter,$reponse){
    
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
            $devise ='---';
            $code_devise ='--';
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



}
