<?php

namespace App\Http\Controllers;

use App\Models\CahierCompteTontine;
use App\Models\CaisseTontine;
use App\Models\CompteMenbre;
use App\Models\Invitation;
use App\Models\Menbre;
use App\Models\MenbreTontine;
use App\Models\Tontine;
use App\Models\Transaction;
use Illuminate\Http\Request;


include EspaceMenbreWaricrowdController::class;
class EspaceMenbre extends Controller
{
    public function accueil(){
        return view('espace_menbre/index');
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

        $titre = $donnees_formulaire['titre'];
        $montant = $donnees_formulaire['montant'];
        $frequence_de_depot = $donnees_formulaire['frequence_depot_en_jours'];
        $nombre_participant = $donnees_formulaire['nombre_participant'];

        if(!empty($titre) && !empty($montant) && !empty($frequence_de_depot) && !empty($nombre_participant)){
            $la_tontine = new Tontine();

            $la_session = session(MenbreController::$cle_session);
            $id_menbre_connecter =  $la_session['id'];
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
                    $route_liste_tontine = route('espace_menbre.liste_tontine');
                    $notification = "<div class='alert alert-success text-center'> Votre tontine a bien été créé, <a href='$route_liste_tontine'>INVITER VOS AMI(E)S</a>  </div>";
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
            $la_tontine->titre = $titre;

            //il ne peut pas modifier la tontines apres que des gens ai payer
            if(sizeof($la_tontine->transactions) <1 ){
                $la_tontine->montant = $montant;
                $la_tontine->frequence_depot_en_jours = $frequence_de_depot;
                $la_tontine->nombre_participant = $nombre_participant;
            }

            if($la_tontine->save()){
                $notification = "<div class='alert alert-success text-center'> Operation bien éffectuée </div>";
            }else{
                $notification = "<div class='alert alert-danger text-center'> Echec de l'Operation, veuillez rééssayer </div>";
            }
            return  redirect()->route('espace_menbre.editer_tontine',[$la_tontine->id])->with('notification',$notification);
        }
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
                ->where('id_menbre_qui_prend','=',$la_tontine->caisse->menbre_qui_prend->id)->first();
            $a_deja_cotiser = ($a_deja_cotiser!=null) ? true : false;

            //Liste des transaction pour le tour courant
            $liste_ayant_cotiser = Transaction::where('id_tontine','=',$id_tontine)
                ->where('id_menbre_qui_prend','=',$la_tontine->caisse->menbre_qui_prend->id)->get();
        }else{
            $liste_ayant_cotiser = [];
            $a_deja_cotiser = false;
        }


        return view("espace_menbre.tontine.details_tontine",compact('la_tontine','invitations_envoyees','pret','a_deja_cotiser','liste_ayant_cotiser'));
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

        $la_caisse_de_la_tontine->montant_objectif= $la_tontine->montant * $la_tontine->nombre_participant;
//        $la_caisse_de_la_tontine->montant= 0;
        $la_caisse_de_la_tontine->id_menbre_qui_prend= $la_tontine->id_menbre;
        $la_caisse_de_la_tontine->prochaine_date_encaissement= $prochaine_date_encaissement;
        $la_caisse_de_la_tontine->save();


        $notification = " <div class='alert alert-success text-center'> Operation bien effectuée </div>";
        return redirect()->back()->with('notification',$notification);
    }

//    =============================INVITATIONA==============================

    public function inviter_des_amis($id_tontine){
        $la_tontine = Tontine::find($id_tontine);
        if($la_tontine == null){
            return redirect()->route('espace_menbre.liste_tontine');
        }
        return view("espace_menbre/tontine/inviter_des_amis",compact("la_tontine"));
    }

    public function envoyer_invitation(Request $request,$id_tontine){
        $donnees_formulaire = $request->all();

        #envoi d'email ici

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];

        $liste_emails = explode(',',$donnees_formulaire['liste_emails']);
//        dd($liste_emails);

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

        $notification = "<div class='alert alert-success text-center'> Operatin bien éffectuée </div>";
        return redirect()->back()->with('notification',$notification);
    }

    public function invitations(){
        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter =  $la_session['id'];
        $le_menbre = Menbre::find($id_menbre_connecter);
        $email_inviter = $le_menbre['email'];


        $invitation_recues = [];
        if($email_inviter!=null){
            $invitation_recues = Invitation::where('email_inviter','=',$email_inviter)->where('etat','=','attente')->get();
        }
        return view("espace_menbre/invitations",compact('invitation_recues'));
    }

    public function reponse_invitation(Request $request,$id_invitation){
        $donnees_formulaire = $request->all();
        $reponse = $donnees_formulaire['reponse'];


        $linvitation = Invitation::find($id_invitation);

        $la_tontine = $linvitation->tontine;

        if(sizeof($la_tontine->participants) < $la_tontine->nombre_participant){
            $linvitation->etat = $reponse;
            $linvitation->save();
            $notification = " <div class='alert alert-success text-center'> Operation bien effectuée </div>";

            if($reponse == 'acceptee'){
                $la_session = session(MenbreController::$cle_session);
                $id_menbre_connecter = $la_session['id'];

                $deja_menbre = MenbreTontine::where('menbre_id','=',$id_menbre_connecter)->where('tontine_id','=',$la_tontine->id)->first();
                if($deja_menbre==null){
                    $nouveau_menbre = new MenbreTontine();
                    $nouveau_menbre->tontine_id = $la_tontine->id;
                    $nouveau_menbre->menbre_id = $id_menbre_connecter;
                    $nouveau_menbre->save();
                }
            }

            if(sizeof($la_tontine->participants) == $la_tontine->nombre_participant){
                 Invitation::where('id_tontine','=',$la_tontine->id)->where('etat','=','attente')->update(['etat'=>"expiree"]);
            }
        }else{
            Invitation::where('id_tontine','=',$la_tontine->id)->where('etat','=','attente')->update(['etat'=>"expiree"]);

            if($reponse == 'acceptee') {
                $notification = " <div class='alert alert-danger text-center'> Le nombre de participant est dejà atteint</div>";
            }else{
                $notification = " <div class='alert alert-success text-center'> Operation bien effectuée </div>";
            }
        }

        return redirect()->back()->with('notification',$notification);
    }

//    ===================Cotisation======================
    public function paiement_cotisation($id_tontine){

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $la_tontine = Tontine::find($id_tontine);
        $montant = $la_tontine->montant;

        $la_transaction = new Transaction();
        $la_transaction->id_tontine = $id_tontine;
        $la_transaction->id_menbre = $id_menbre_connecter;
        $la_transaction->montant = $montant;
        $la_transaction->id_menbre_qui_prend = $la_tontine->caisse->menbre_qui_prend->id;

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

//===================Montant atteinds
            if($nouveau_montant == $la_caisse_de_la_tontine->montant_objectif){
                $index_menbre_qui_prend = $la_caisse_de_la_tontine->index_menbre_qui_prend;
                $nouvel_index = $index_menbre_qui_prend + 1;

//===================Virer l'argent sur son compte et le noter dans le cahier
                $id_menbre_qui_prend = $la_caisse_de_la_tontine->id_menbre_qui_prend;
                $le_compte = CompteMenbre::findOrNew($id_menbre_qui_prend);
                $le_compte->id_menbre = $id_menbre_qui_prend;
                $le_solde = $le_compte->montant;
                $nouveau_solde = $le_solde + $nouveau_montant;
                $le_compte->solde = $nouveau_solde;
                //noter le virement dans le cahier comptable
                if($le_compte->save()){
                    $nouvelle_note = new CahierCompteTontine();
                    $nouvelle_note->id_menbre = $id_menbre_qui_prend;
                    $nouvelle_note->id_tontine = $id_tontine;
                    $nouvelle_note->montant = $nouveau_montant;
                    $nouvelle_note->save();
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

                    $la_tontine->etat = 'fermee';
                    $la_tontine->save();
                    $notification = " <div class='alert alert-warning text-center'> Operation bien effectuée, Fin de la tontine est complete </div>";
                }

            }

        }
        return redirect()->back()->with('notification',$notification);
    }

//====================== PROFIL=======================
    public function profil($id_menbre){
        $le_menbre = Menbre::find($id_menbre);
        return view('espace_menbre/profil',compact('le_menbre'));
    }

    public function modifier_profil(Request $request,$id_menbre){
            $couleur = "danger";

            $donnee_formulaire = $request->all();
//        dd($donnee_formulaire);
            $mot_de_passe_actuel = $donnee_formulaire['mot_de_passe_actuel'];
            $bon_mot_de_passe = $this->VerifieLeMotDePasse($mot_de_passe_actuel,$id_menbre);

            if($bon_mot_de_passe){
                $nom_complet = $donnee_formulaire['nom_complet'];
                $telephone = $donnee_formulaire['telephone'];
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

                $telephone_existe_deja = $this->checkExistenceNumeroPourAutrePersonne($telephone,$id_menbre);
                if($telephone_existe_deja){
                    $message = "Ce numero de telephone a déja utilisé par une autre personne";
                    $notification = "<div class='alert alert-$couleur'> $message  </div>";
                    return redirect()->back()->with('notification',$notification);
                }

//        ---------------Verifie mot de passe et enregistrement

                $le_menbre = Menbre::find($id_menbre);
                $le_menbre->nom_complet = $nom_complet;
                $le_menbre->telephone = $telephone;
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
                    $notification = "<div class='alert alert-$couleur'> $message  </div>";
                    return redirect()->back()->with('notification',$notification);
                }

            }else{
                $message = "Mot de passe actuel incorrect";
                $notification = "<div class='alert alert-$couleur'> $message  </div>";
            }


        $notification = "<div class='alert alert-$couleur'> $message  </div>";
        return redirect()->back()->with('notification',$notification);
    }


//=========================================FONCTION UTILITAIRE
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


}
