<?php

namespace App\Http\Controllers;

use App\Events\WaribanaChatMessage;
use App\Models\CahierCompteTontine;
use App\Models\CaisseTontine;
use App\Models\ChatTontineMessage;
use App\Models\CompteMenbre;
use App\Models\Invitation;
use App\Models\Menbre;
use App\Models\MenbreTontine;
use App\Models\SmsContenuNotification;
use App\Models\Tontine;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;


class EspaceMenbre extends Controller
{

    public function accueil(){
        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $le_menbre = Menbre::find($id_menbre_connecter);

        $email_inviter = $le_menbre->email;
        $nombre_invitation_recues = 0;
        if($email_inviter!=null){
            $nombre_invitation_recues = Invitation::where('email_inviter','=',$email_inviter)->where('etat','=','attente')->count();
        }
        return view('espace_menbre/index',compact('le_menbre','nombre_invitation_recues'));
    }

    public function deconnexion(){
        session()->pull(MenbreController::$cle_session);
        return redirect()->route('connexion_menbre');
    }


//    ===================Tontines======================
    public function editer_tontine($id_tontine){

        $la_session = session(MenbreController::$cle_session);

        $la_tontine = Tontine::where('id','=',$id_tontine)->first();
        if($la_session['id'] == $la_tontine->id_menbre){
            return view('espace_menbre/tontine/editer_tontine',compact('la_tontine'));
        }else{
            return redirect()->route('espace_menbre.deconnexion');
        }
    }

    public function ajouter_tontine(){
        return view('espace_menbre/tontine/creer_tontine');
    }

    public function enregistrer_tontine(Request $request){
        $donnees_formulaire = $request->all();
        //        dd($donnees_formulaire);

        $identifiant_adhesion = intdiv( (rand(111,999) * rand(11,99)) ,12 );
        $titre = $donnees_formulaire['titre'];
        $montant = $donnees_formulaire['montant'];
        $frequence_de_depot = $donnees_formulaire['frequence_depot_en_jours'];
        $nombre_participant = $donnees_formulaire['nombre_participant'];

        if(!empty($titre) && !empty($montant) && !empty($frequence_de_depot) && !empty($nombre_participant)){
            $la_tontine = new Tontine();

            $la_session = session(MenbreController::$cle_session);
            $id_menbre_connecter =  $la_session['id'];
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
                    $notification = "<div class='alert alert-success text-center'> Votre tontine a bien été créé, <a href='$route_details_tontine'>INVITER VOS AMI(E)S</a>  </div>";
                }else{
                    $notification = "<div class='alert alert-danger text-center'> Un probleme est survenu </div>";
                }

            }else{
                $notification = "<div class='alert alert-danger text-center'> Echec de l'Operation, veuillez rééssayer </div>";
            }
            return  redirect()->route('espace_menbre.ajouter_tontine')->with('notification',$notification);
        }
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
                return redirect()->route('espace_menbre.liste_tontine');
            }

            $la_session = session(MenbreController::$cle_session);
            $id_menbre_connecter =  $la_session['id'];

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
                $notification = "<div class='alert alert-success text-center'> Operation bien éffectuée </div>";
            }else{
                $notification = "<div class='alert alert-danger text-center'> Echec de l'Operation, veuillez rééssayer </div>";
            }
            return  redirect()->route('espace_menbre.editer_tontine',[$la_tontine->id])->with('notification',$notification);
        }
    }

    public function supprimer_tontine(Request $request,$id_tontine){
        $la_tontine = Tontine::find($id_tontine);
        return view('espace_menbre/tontine/supprimer_tontine',compact('la_tontine'));
    }

    public function post_supprimer_tontine(Request $request,$id_tontine){
        $la_tontine = Tontine::find($id_tontine);
//        dd($la_tontine->transactions);
        if(sizeof($la_tontine->transactions) == 0){
            $la_tontine->delete();
            $notification = "<div class='alert alert-success text-center'>Operation bien effectuée</div>";
        }else{
            $notification = "<div class='alert alert-danger text-center'>Vous ne pouvez pas supprimer une tontine apres que des transactions ai été effectuées</div>";
        }
        return redirect()->route('espace_menbre.liste_tontine')->with('notification',$notification);
    }

    public function liste_tontine(){
        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $le_menbre_connecter =  Menbre::find($id_menbre_connecter);
        $mes_tontines = $le_menbre_connecter->tontines;
        return view('espace_menbre/tontine/liste_tontine',compact('mes_tontines'));
    }

    public function details_tontine($id_tontine){


        $la_tontine = Tontine::find($id_tontine);

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];

        $id_menbre_qui_prend =null;
        if($la_tontine->caisse != null){
            $id_menbre_qui_prend = $la_tontine->caisse->menbre_qui_prend->id;
        }
        $invitations_envoyees = Invitation::where("menbre_qui_invite",'=',$id_menbre_connecter)->where('id_tontine','=',$id_tontine)->get();
        if($la_tontine ==null){
            return redirect()->route('espace_menbre.liste_tontine');
        }

        //afficher les autre section seulement si le nombre de particpant est atteinds
        $pret = false;

        if($la_tontine->nombre_participant == sizeof($la_tontine->participants)){
            $pret = true;
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
                ->get();
        }else{
            $liste_ayant_cotiser = [];
            $a_deja_cotiser = false;
        }

//a decoder a la notication;utiliser pour recuperer la trasaction sans l'id
        $notre_custom_field = "id_menbre=$id_menbre_connecter&id_tontine=$id_tontine&id_menbre_qui_prend=$id_menbre_qui_prend";
//        parse_str($a, $output);
        return view("espace_menbre.tontine.details_tontine",compact('la_tontine','invitations_envoyees',
                            'pret','a_deja_cotiser','liste_ayant_cotiser',
                            'notre_custom_field'));
    }

    public function ouvrir_tontine($id_tontine){
        $la_tontine = Tontine::find($id_tontine);
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


        $notification = " <div class='alert alert-success text-center'> Operation bien effectuée </div>";
        return redirect()->back()->with('notification',$notification);
    }

//    =============================INVITATIONS==============================

//    ===================Cotisation======================
    public function paiement_cotisation($id_tontine){

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

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $le_menbre = Menbre::find($id_menbre_connecter);
        
        $route_back_en_cas_derreur = route('espace_menbre.details_tontine',[$id_tontine]);
        $payment_url = CinetpayPaiementController::generer_lien_paiement($le_menbre,$id_tontine,$le_montant_en_xof,$le_montant,'tontine',$route_back_en_cas_derreur);
        return redirect($payment_url);
//=========================POUR SIMULATION=============================
/*====================/simulation=============
        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $le_menbre = Menbre::find($id_menbre_connecter);
        $la_tontine = Tontine::find($id_tontine);
        $montant = $la_tontine->montant;

        $la_transaction = new Transaction();
        $la_transaction->id_tontine = $id_tontine;
        $la_transaction->id_menbre = $id_menbre_connecter;
        $la_transaction->montant = $montant;
        $la_transaction->statut = "ACCEPTED";
        $la_transaction->id_menbre_qui_prend = $la_tontine->caisse->menbre_qui_prend->id;
        $la_transaction->index_ouverture = $la_tontine->caisse->index_ouverture;

        $notification = " <div class='alert alert-danger text-center'> Quelque chose s'est mal passé, veuillez reessayez </div>";
        if($la_transaction->save()){
            $la_caisse_de_la_tontine = CaisseTontine::findOrNew($id_tontine);
            $la_caisse_de_la_tontine->id_tontine= $id_tontine;
            $nouveau_montant = $la_caisse_de_la_tontine->montant;
            $nouveau_montant += $montant;
            $la_caisse_de_la_tontine->montant = $nouveau_montant;

            if($la_caisse_de_la_tontine->save()){
                $notification = " <div class='alert alert-success text-center'> Operation bien effectuée </div>";
            }

            $maintenant = date('d/m/Y H:i', strtotime(now()));
//            dd($maintenant);
            $liste_participants = $la_tontine->participants;
//            dd($liste_participants);
            $this->notifier_paiement_cotisation($liste_participants,$le_menbre->nom_complet,$montant,$la_tontine->createur->devise_choisie->monaie,$la_tontine->titre,$maintenant);

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
                $le_compte = CompteMenbre::findOrNew($id_menbre_qui_prend);
                $le_compte->id_menbre = $id_menbre_qui_prend;
                $le_solde = $le_compte->solde;
                $nouveau_solde = $le_solde + $montant_a_verser;
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
                    
                    $headers = 'From: no-reply@waribana.net' . "\r\n" .
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
                    $notification = " <div class='alert alert-warning text-center'> Operation bien effectuée, La tontine est complete (Terminer) </div>";
                }

            }

        }
        return redirect()->back()->with('notification',$notification);
====================/simulation=============*/
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
        // $chemin_fichier = route('get_recu',[$nom_fichier]);
        $chemin_fichier = Storage::disk('public')->path("recu/tontines/".$nom_fichier);

        $rep = EspaceMenbreWaricrowdController::envoyer_email_avec_fichier($email,"RECU DE PAIEMENT WARICROWD",$message,$chemin_fichier,$nom_fichier);
//        dd($chemin_fichier,$nom_fichier,$rep);
//        return $pdf->stream();
    }

//    ===================CHAT======================

    public function chat_tontine($id_tontine){

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $le_menbre = Menbre::find($id_menbre_connecter);
        $maintenant = date('d-m-Y H:i:s');
        $le_menbre->date_derniere_visite = $maintenant;
        $le_menbre->save();

        Carbon::setLocale('fr');

        $la_tontine = Tontine::find($id_tontine);
        $les_anciens_message = ChatTontineMessage::where('id_tontine','=',$id_tontine)->get();
        return view('espace_menbre/tontine/chat/chat_tontine',compact('la_tontine','les_anciens_message','le_menbre'));
    }

    public function chat_tontine_envoyer_message(Request $request,$id_tontine){

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $nom_complet = $la_session['nom_complet'];


        $donnee_formulaire = $request->input();
        $message = $donnee_formulaire['message'];
        //declencher le broadcast
        event(new WaribanaChatMessage($id_tontine,$id_menbre_connecter,$nom_complet,$message));

        //enregistrer
        $le_message = new ChatTontineMessage();
        $le_message->id_tontine = $id_tontine;
        $le_message->id_menbre = $id_menbre_connecter;
        $le_message->message = $message;
        $le_message->save();

    }


    public function chat_tontine_qui_est_en_ligne($id_tontine){
        Carbon::setLocale('fr');

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $le_menbre = Menbre::find($id_menbre_connecter);
        $maintenant = date('d-m-Y H:i:s');
        $le_menbre->date_derniere_visite = $maintenant;
        $le_menbre->save();

        $la_tontine = Tontine::find($id_tontine);
        return view('espace_menbre/tontine/chat/liste_menbre_tontine_en_ligne',compact('la_tontine'));
    }

//====================== PROFIL=======================
    public function profil($id_menbre){
        $le_menbre = Menbre::find($id_menbre);
        return view('espace_menbre/profil/profil',compact('le_menbre'));
    }

    public function modifier_profil(Request $request,$id_menbre){
        $couleur = "danger";

        $donnee_formulaire = $request->all();
        //        dd($donnee_formulaire);
        $mot_de_passe_actuel = $donnee_formulaire['mot_de_passe_actuel'];
        $bon_mot_de_passe = $this->VerifieLeMotDePasse($mot_de_passe_actuel,$id_menbre);

        if($bon_mot_de_passe){
            $nom_complet = $donnee_formulaire['nom_complet'];
        //            $telephone = $donnee_formulaire['telephone'];
            $email = $donnee_formulaire['email'];
            $mot_de_passe = $donnee_formulaire['mot_de_passe'];
            $confirmer_mot_de_passe = $donnee_formulaire['confirmer_mot_de_passe'];

        //        ---------------Verifie existence des identifiant
            if($email !=null){
                $route_connexion = route('connexion_menbre');
                $email_existe_deja = $this->checkExistenceEmailPourAutrePersonne($email,$id_menbre);
                if($email_existe_deja){
                    $message = "Cette adresse email est déja utilisée par une autre personne";
                    $notification = "<div class='alert alert-$couleur'> $message  </div>";
                    return redirect()->back()->with('notification',$notification);
                }
            }

        //        ---------------Verifie mot de passe et enregistrement

            $le_menbre = Menbre::find($id_menbre);
            $le_menbre->nom_complet = $nom_complet;
        //            $le_menbre->telephone = $telephone;
            $le_menbre->email = $email;

            if(!empty($mot_de_passe) && !empty($confirmer_mot_de_passe) ){
                if($mot_de_passe != $confirmer_mot_de_passe){
                    $couleur = "danger";
                    $message = "Les mots de passe ne sont pas identiques.";
                    $notification = "<div class='alert alert-$couleur'> $message  </div>";
                    return redirect()->back()->with('notification',$notification);
                }
                $mot_de_passe_cacher = md5($confirmer_mot_de_passe);
                $le_menbre->mot_de_passe = $mot_de_passe_cacher;
            }

            if($le_menbre->save()){
                $couleur = "success";
                $message = "Operation bien effectuée";
                $notification = "<div class='alert alert-$couleur  text-center'> $message  </div>";
                return redirect()->back()->with('notification',$notification);
            }

        }else{
            $message = "Mot de passe actuel incorrect";
            $notification = "<div class='alert alert-$couleur'> $message  </div>";
        }


        $notification = "<div class='alert alert-$couleur'> $message  </div>";
        return redirect()->back()->with('notification',$notification);
    }


    public function modifier_telephone_compte(Request $request)
    {
        $la_session = session(MenbreController::$cle_session);
        if ($la_session == null) {
            return redirect()->route('connexion_menbre');
        } else {
            $id_menbre_connecter = $la_session['id'];
            $le_menbre = Menbre::find($id_menbre_connecter);
            if ($le_menbre == null) {
                return redirect()->route('connexion_menbre');
            } elseif ($le_menbre->etat != 'actif') {
                return redirect()->route('espace_menbre.deconnexion');
            }
        }

        //nouveau code
        $code_de_confirmation = rand(1111, 9999) * 12;
        $le_menbre->code_de_confirmation = $code_de_confirmation;
        $le_menbre->save();

        $notification = "<div class='alert alert-danger text-center'>Numero Invalide</div>";
        $donnees_formulaire = $request->all();
        $telephone = $donnees_formulaire['nouveau_telephone'];
        if (is_numeric($telephone)) {
            if (!($this->checkExistenceNumeroPourAutrePersonne($telephone,$id_menbre_connecter))) {
                $le_numero = $telephone;
                $code = $le_menbre->code_de_confirmation;
        //                dd($code);
                $contenu_notification = SmsContenuNotification::first();
                $message_confirmation = $contenu_notification['confirmation_compte'];
                $le_message = str_replace('$code$',$code,$message_confirmation);
        //                dd($le_numero);
                SmsController::sms_info_bip($le_numero, $le_message);
        //                return redirect()->route('espace_menbre.entrer_code_confirmation_pour_modification',compact('le_numero'));
                return view('espace_menbre/profil/entrer_code_confirmation_pour_modification',compact('le_numero'));
            } else {
                return redirect()->back()->with('notification', $notification);
            }
        } else {
            return redirect()->back()->with('notification', $notification);
        };
    }

    public function entrer_code_confirmation_pour_modification(){
//modification de telephone
        $la_session = session(MenbreController::$cle_session);
        if ($la_session == null) {
            return redirect()->route('connexion_menbre');
        } else {
            $id_menbre_connecter = $la_session['id'];
            $le_menbre = Menbre::find($id_menbre_connecter);
            if ($le_menbre == null) {
                return redirect()->route('connexion_menbre');
            } elseif ($le_menbre->etat != 'actif') {
                return redirect()->route('espace_menbre.deconnexion');
            }
        }

        return view("espace_menbre/profil/entrer_code_confirmation_pour_modification", compact('le_menbre'));
    }

    public function post_entrer_code_confirmation_pour_modification(Request $request)
    {
        $la_session = session(MenbreController::$cle_session);
        if ($la_session == null) {
            return redirect()->route('connexion_menbre');
        } else {
            $id_menbre_connecter = $la_session['id'];
            $le_menbre = Menbre::find($id_menbre_connecter);
            if ($le_menbre == null) {
                return redirect()->route('connexion_menbre');
            } elseif ($le_menbre->etat != 'actif') {
                return redirect()->route('connexion_menbre');
            }
        }

        $donnees_formulaire = $request->all();
        $le_code = $donnees_formulaire['code'];
        $nouveau_telephone = $donnees_formulaire['nouveau_telephone'];
        if ($le_code == $le_menbre->code_de_confirmation) {
            $le_menbre->telephone = $nouveau_telephone;
            $le_menbre->save();
            $notification = "<div class='alert alert-success text-center'>Operation bien effectuée.</div>";
            return redirect()->route('espace_menbre.profil',[$id_menbre_connecter])->with('notification',$notification);
        }else {
            $notification = "<div class='alert alert-danger text-center'>code invalide, rééssayez.</div>";
            return redirect()->route('espace_menbre.profil',[$id_menbre_connecter])->with('notification', $notification);
        }
    }

  
    public function confirmer_retrait_dargent(Request $request){
        $donnees_formulaire = $request->input();
        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $mdp = $donnees_formulaire['mot_de_passe_actuel'];
        $montant_retrait = $donnees_formulaire['montant'];
        $mdp_md5 = md5($mdp);

        $utlisateur_existe = Menbre::where('id','=',$id_menbre_connecter)->where('mot_de_passe','=',$mdp_md5)->first();

        if($utlisateur_existe){
            $le_menbre = Menbre::find($id_menbre_connecter);

            //est qu'il dispose de cette somme sur son compte
            if($le_menbre->compte->solde < $montant_retrait){
                $notification = "<div class='alert alert-danger text-center'> VOUS NE DISPOSEZ PAS DE CE MONTANT. </div>";
                return redirect()->back()->with('notification',$notification);
            }
            
            // CONVERSION EN CFA AVANT TRANSFERT
            $le_montant = $montant_retrait;
            if($le_menbre->devise_choisie->code != "XOF"){
                $monaie_createur_tontine = $le_crowd->createur->devise_choisie->code;
                $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion($monaie_createur_tontine,"XOF");
                $le_montant_en_xof = $quotient_de_conversion * $le_montant;
            }else{
                $le_montant_en_xof = $le_montant;
            }
        // CONVERSION EN CFA AVANT TRANSFERT

            $response = \App\Http\Controllers\CinetpayApiTransfertController::effectuer_un_retrait($le_menbre,$le_montant_en_xof);
            $reponse_decoder = json_decode($response);
            $code = $reponse_decoder->code;
            $message = $reponse_decoder->message;
            
            
            if($code == 0){ // 0 = succes , les autres = prbleme
                $notification = "<div class='alert alert-success text-center'> Retrait bien effectué </div>";
                \App\Http\Controllers\CinetpayApiTransfertController::enregistrer_retrait($le_menbre,$montant_retrait);
                $monaie = $le_menbre->devise_choisie->monaie;
                
                
                $headers = 'From: no-reply@waribana.net' . "\r\n" .
                     'Reply-To: no-reply@waribana.net' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();
                mail($le_menbre->email,'RETRAIT EFFECTUER',"Bonjour $le_menbre->nom_complet, votre retrait de $montant_retrait $monaie a bien été effectué.",$headers);
            }else{
                $notification = "<div class='alert alert-danger text-center'> Echec de retrait, motif : $message </div>";
            }
            return redirect()->back()->with('notification',$notification);
        }else{
            $notification = "<div class='alert alert-danger text-center'> Mot de passe Incorrect </div>";
            return redirect()->back()->with('notification',$notification);
        };
    }

//=========================================FONCTION UTILITAIRE=======================================
    private function checkExistenceEmailPourAutrePersonne($email,$id_menbre){
        $menbre_existant = Menbre::where('email','=',$email)->where('id','!=',$id_menbre)->first();
        if($menbre_existant != null){
            return true;
        }else{
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

    private function notifier_paiement_cotisation($liste_participants,$nom_cotiseur,$montant_cotisation,$devise,$titre_de_la_tontine,$date_paiement){
        foreach($liste_participants as $item_participant){
            $numero = "$item_participant->telephone";
//            dd($montant_cotisation);
//            $montant_cotisation = number_format($montant_cotisation,0,',',' ');
            $message_sms = "Paiement de $montant_cotisation $devise par $nom_cotiseur sur la totine <<$titre_de_la_tontine>> le $date_paiement ";
//            dd($message_sms);
            SmsController::sms_info_bip("$numero",$message_sms);
        }
//        die();
    }


}
