<?php

namespace App\Http\Controllers;

use App\Models\CaisseTontine;
use App\Models\CahierCompteTontine;
use App\Models\CahierRetraitSoldeMenbre;
use App\Models\CategorieWaricrowd;
use App\Models\Invitation;
use App\Models\Menbre;
use App\Models\SmsContenuNotification;
use App\Models\Tontine;
use App\Models\Transaction;
use App\Models\TransactionWaricrowd;
use App\Models\Waricrowd;
use App\Models\Parametre;
use App\Models\User;
use Illuminate\Http\Request;

class AdministrateurController extends Controller
{
//    ===============================TONTINES
    public function les_tontines(){
        $les_tontines = Tontine::orderBy('id','DESC')->get();
        return view("administrateur/tontines/liste",compact('les_tontines'));
    }

    public function details_tontine($id_tontine){
        $la_tontine = Tontine::find($id_tontine);

        $liste_ayant_cotiser = [];
        if($la_tontine->caisse!=null){
            //Liste des transaction pour le tour courant
            $liste_ayant_cotiser = Transaction::where('id_tontine','=',$id_tontine)
                ->where('id_menbre_qui_prend','=',$la_tontine->caisse->menbre_qui_prend->id)
                ->where('statut','=','ACCEPTED')
                ->get();
        }

        $invitations_envoyees = Invitation::where('id_tontine','=',$id_tontine)->get();
        $transactions_de_la_tontine = $la_tontine->transactions;
        return view("administrateur/tontines/details_tontine",compact('la_tontine','invitations_envoyees','liste_ayant_cotiser','transactions_de_la_tontine'));
    }

    public function historique_transactions_tontine(){
        $date_fin =null;
        $date_debut =null;
        if(isset($_GET['date_debut']) && $_GET['date_fin']){
            $date_debut = $_GET['date_debut'];
            $date_fin = $_GET['date_fin'];

            
            $date_debut_pour_esquiver_probleme_avec_timestamps = date('Y-m-d H:i:s',strtotime($_GET['date_debut']));
            $date_fin_pour_esquiver_probleme_avec_timestamps = date('Y-m-d H:i:s',strtotime($_GET['date_fin']));
            $historique_transactions_tontine = Transaction::where('created_at','>=',$date_debut_pour_esquiver_probleme_avec_timestamps)
                                                ->where('created_at','<=',$date_fin_pour_esquiver_probleme_avec_timestamps)->orderBy('id','desc')->get();
        }else{
            $historique_transactions_tontine = Transaction::orderBy('id','desc')->limit(250)->get();
        }
        //        dd($historique_transactions_waricrowd);
        return view('administrateur/tontines/historique_transactions_tontine',compact('historique_transactions_tontine','date_debut','date_fin'));
    }
    
    
    public function historique_profil(){
        $date_fin =null;
        $date_debut =null;
        if(isset($_GET['date_debut']) && $_GET['date_fin']){
            $date_debut = $_GET['date_debut'];
            $date_fin = $_GET['date_fin'];

            
            $date_debut_pour_esquiver_probleme_avec_timestamps = date('Y-m-d H:i:s',strtotime($_GET['date_debut']));
            $date_fin_pour_esquiver_probleme_avec_timestamps = date('Y-m-d H:i:s',strtotime($_GET['date_fin']));
            $historique_profil = \App\Models\HistoriqueModifProfilMembre::where('created_at','>=',$date_debut_pour_esquiver_probleme_avec_timestamps)
                                                ->where('created_at','<=',$date_fin_pour_esquiver_probleme_avec_timestamps)->orderBy('id','desc')->get();
        }else{
            $historique_profil = \App\Models\HistoriqueModifProfilMembre::orderBy('id','desc')->get();
        }
        //        dd($historique_transactions_waricrowd);
        return view('administrateur/historique_profil',compact('historique_profil','date_debut','date_fin'));
    }
    
    public function changer_etat_tontine(Request $request,$id_tontine){

        $donnees_formulaire = $request->all();
        $nouvel_etat = $donnees_formulaire['nouvel_etat'];
        $motif_intervention = $donnees_formulaire['motif_intervention'];

//        dd($donnees_formulaire);

        $la_tontine = Tontine::find($id_tontine);
        $la_tontine->etat = $nouvel_etat;
        $la_tontine->motif_intervention_admin = $motif_intervention;


        if($nouvel_etat =='ouverte'){

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

        }


        if($la_tontine->save()){
            $notification ="<div class='alert alert-success text-center'> Operation bien ??ffectu??e </div>";
        }else{
            $notification ="<div class='alert alert-danger text-center'> Quelque chose s'est mal pass?? </div>";
        }


        $telephone = $la_tontine->createur->telephone;
        $contenu_notification = SmsContenuNotification::first();
        $message_notif = $contenu_notification['etat_tontine'];

        $le_message = str_replace('$etat$',$nouvel_etat,$message_notif);
        $le_message = str_replace('$titre$',$la_tontine->titre,$le_message);

        if(!empty($motif_intervention)){
            $le_message = str_replace('$motif$',",motif : $motif_intervention",$le_message);
        }else{
            $le_message = str_replace('$motif$',"",$le_message);
        }

        SmsController::sms_info_bip($telephone,$le_message);

        return redirect()->back()->with('notification',$notification);
    }
    
    public function historique_versements(){
        $date_fin =null;
        $date_debut =null;
        if(isset($_GET['date_debut']) && $_GET['date_fin']){
            $date_debut = $_GET['date_debut'];
            $date_fin = $_GET['date_fin'];

            $date_debut_pour_esquiver_probleme_avec_timestamps = date('Y-m-d H:i:s',strtotime($_GET['date_debut']));
            $date_fin_pour_esquiver_probleme_avec_timestamps = date('Y-m-d H:i:s',strtotime($_GET['date_fin']));
            $historique_versements = CahierCompteTontine::where('created_at','>=',$date_debut_pour_esquiver_probleme_avec_timestamps)
                                                ->where('created_at','<=',$date_fin_pour_esquiver_probleme_avec_timestamps)->orderBy('id','desc')->get();
        }else{
            $historique_versements = CahierCompteTontine::orderBy('id','desc')->limit(250)->get();
        }
        //        dd($historique_transactions_waricrowd);
        return view('administrateur/tontines/historique_versements',compact('historique_versements','date_debut','date_fin'));
    }

//    ===============================WARICROWD

    public function ajouter_categorie_waricrowd(){
        $liste_categorie_waricrowd = CategorieWaricrowd::orderBy('id','desc')->get();
        return view("administrateur/waricrowds/categories/index",compact('liste_categorie_waricrowd'));
    }

    public function enregistrer_categorie_waricrowd(Request $request){
        $donnees_formulaire = $request->all();
        $titre = $donnees_formulaire['titre'];
        $la_categorie_existe = CategorieWaricrowd::where('titre','=',$titre)->first();
        if($la_categorie_existe==null){
            $la_categorie = new CategorieWaricrowd();
            $la_categorie->titre = $titre;
            $la_categorie->save();
            $notification = "<div class='alert alert-success text-center'> Operation bien effectuee </div>";
        }else{
            $notification = "<div class='alert alert-danger text-center'> Cette categorie existe deja </div>";
        }
        return redirect()->back()->with('notification',$notification);
    }

    public function modifier_categorie_waricrowd(Request $request,$id_categorie){
        $donnees_formulaire = $request->all();
        $titre = $donnees_formulaire['titre'];
        $la_categorie = CategorieWaricrowd::find($id_categorie);
        $la_categorie->titre = $titre;
        $la_categorie->save();
        $notification = "<div class='alert alert-success text-center'> Operation bien effectuee </div>";
        return redirect()->back()->with('notification',$notification);
    }

    public function effacer_categorie_waricrowd($id_categorie){
        $la_categorie = CategorieWaricrowd::find($id_categorie);
        $la_categorie->delete();
        $notification = "<div class='alert alert-success text-center'> Operation bien effectuee </div>";
        return redirect()->back()->with('notification',$notification);
    }

    public function les_waricrowds($filtre=null){
        if($filtre!=null){
            $liste_waricrowd = Waricrowd::where('etat','=',$filtre)->orderBy('id','desc')->get();
        }else{
            $liste_waricrowd = Waricrowd::orderBy('id','desc')->get();
        }
        return view("administrateur/waricrowds/liste",compact('liste_waricrowd'));
    }
    public function details_waricrowd($id_crowd){
        $le_crowd = Waricrowd::find($id_crowd);

        $transactions_du_waricrowd = $le_crowd->transactions;
        return view("administrateur/waricrowds/details_waricrowd",compact('le_crowd','transactions_du_waricrowd'));
    }


    public function editer_crowd($id_crowd){
        $le_crowd = Waricrowd::find($id_crowd);
        $liste_categorie_waricrowd = CategorieWaricrowd::all();
        return view('administrateur/waricrowds/editer_waricrowd',compact('le_crowd','liste_categorie_waricrowd'));
    }

       public function modifier_un_waricrowd(Request $request,$id_crowd)
    {
        $donnees_formulaire = $request->all();

        $id_categorie_waricrowd = $donnees_formulaire['id_categorie_waricrowd'];
        $titre = $donnees_formulaire['titre'];
        $description_courte = $donnees_formulaire['description_courte'];
        $description_complete = $donnees_formulaire['description_complete'];
        $montant_objectif = $donnees_formulaire['montant_objectif'];
        $pitch_video = $this->formaterLienPitch($donnees_formulaire['lien_pitch_video']);

        $le_crowd = Waricrowd::find($id_crowd);

        if(sizeof($le_crowd->transactions) > 0 ){
            $notification = "<div class='alert alert-danger text-center'> Vous ne pouvez pas modifier un crowd apres que des transactions ai ??t?? effectu??es </div>";
            return redirect()->back()->with("notification",$notification);
        }
    
        $le_crowd->id_categorie = $id_categorie_waricrowd;
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

            $notification = "<div class='alert alert-success text-center'> Operation effectu??e avec succes </div>";
        }else{
            $notification = "<div class='alert alert-danger text-center'> Quelquechose s'est mal pass??e, veuillez r????ssayer </div>";
        }

        return redirect()->back()->with("notification",$notification);
    }



    public function changer_etat_crowd(Request $request,$id_crowd){

        $donnees_formulaire = $request->all();
        $nouvel_etat = $donnees_formulaire['nouvel_etat'];
        $motif_intervention = $donnees_formulaire['motif_intervention'];

//        dd($donnees_formulaire);

        $le_crowd = Waricrowd::find($id_crowd);
        $le_crowd->etat = $nouvel_etat;
        $le_crowd->motif_intervention_admin = $motif_intervention;


        $telephone = $le_crowd->createur->telephone;
        $contenu_notification = SmsContenuNotification::first();
        $message_notif = $contenu_notification['etat_waricowd'];

        $le_message = str_replace('$etat$',$nouvel_etat,$message_notif);
        $le_message = str_replace('$titre$',$le_crowd->titre,$le_message);

        if(!empty($motif_intervention)){
            $le_message = str_replace('$motif$',",motif : $motif_intervention",$le_message);
        }else{
            $le_message = str_replace('$motif$',"",$le_message);
        }

        SmsController::sms_info_bip($telephone,$le_message);
//        dd($le_message,$telephone);

        if($le_crowd->save()){
            $notification ="<div class='alert alert-success text-center'> Operation bien ??ffectu??e </div>";
        }else{
            $notification ="<div class='alert alert-danger text-center'> Quelque chose s'est mal pass?? </div>";
        }


        return redirect()->back()->with('notification',$notification);
    }

//    ===============================GESTION MENBRES EXTERNES
    public function liste_menbres_inscrits($filtre=null){
        // dd($filtre);
        if($filtre!=null){
            $liste_menbres_inscrits = Menbre::where('etat','=',$filtre)->get();
        }else{
            $liste_menbres_inscrits = Menbre::all();
        }
        return view('administrateur/liste_menbres_inscrits',compact('liste_menbres_inscrits','filtre'));
    }

    public function suspendre_menbre(Request $request,$id_menbre){

        $donnees_formulaire = $request->all();
        $nouvel_etat = $donnees_formulaire['nouvel_etat'];
        $motif_intervention = $donnees_formulaire['motif_intervention'];

//        dd($donnees_formulaire);

        $le_menbre = Menbre::find($id_menbre);
        $le_menbre->etat = $nouvel_etat;
        $le_menbre->motif_intervention_admin = $motif_intervention;
        if($le_menbre->save()){
            $notification ="<div class='alert alert-success text-center'> Operation bien ??ffectu??e </div>";
        }else{
            $notification ="<div class='alert alert-danger text-center'> Quelque chose s'est mal pass?? </div>";
        }

        return redirect()->back()->with('notification',$notification);
    }

    public function historique_transactions_waricrowd(){
        $date_fin =null;
        $date_debut =null;
        if(isset($_GET['date_debut']) && $_GET['date_fin']){
            $date_debut = $_GET['date_debut'];
            $date_fin = $_GET['date_fin'];

            $date_debut_pour_esquiver_probleme_avec_timestamps = date('Y-m-d H:i:s',strtotime($_GET['date_debut']."- 1 hours"));
            $date_fin_pour_esquiver_probleme_avec_timestamps = date('Y-m-d H:i:s',strtotime($_GET['date_fin']."+ 1 hours"));
            
            // dd(date('H:i:s',strtotime($_GET['date_debut'])));
            $historique_transactions_waricrowd = TransactionWaricrowd::orderBy('id','desc')
                ->where('created_at','>=',$date_debut_pour_esquiver_probleme_avec_timestamps)
                ->where('created_at','<=',$date_fin_pour_esquiver_probleme_avec_timestamps)
                // ->whereTime('created_at', '>=', date('H:i:s',strtotime($_GET['date_debut'])))
                ->get();
            // dd($date_debut_pour_esquiver_probleme_avec_timestamps);
        }else{
            $historique_transactions_waricrowd = TransactionWaricrowd::orderBy('id','desc')->limit(250)->get();
        }
        //        dd($historique_transactions_waricrowd);
        return view('administrateur/waricrowds/historique_transactions_waricrowd',compact('historique_transactions_waricrowd','date_debut','date_fin'));
    }
    
    public function historique_retraits(){
        $date_fin =null;
        $date_debut =null;
        if(isset($_GET['date_debut']) && $_GET['date_fin']){
            $date_debut = $_GET['date_debut'];
            $date_fin = $_GET['date_fin'];

            
            $date_debut_pour_esquiver_probleme_avec_timestamps = date('Y-m-d H:i:s',strtotime($_GET['date_debut']."- 1 hours"));
            $date_fin_pour_esquiver_probleme_avec_timestamps = date('Y-m-d H:i:s',strtotime($_GET['date_fin']."+ 1 hours"));
            $historique_retraits = CahierRetraitSoldeMenbre::where('created_at','>=',$date_debut_pour_esquiver_probleme_avec_timestamps)
                                                ->where('created_at','<=',$date_fin_pour_esquiver_probleme_avec_timestamps)->orderBy('id','desc')->get();
        }else{
            $historique_retraits = CahierRetraitSoldeMenbre::orderBy('id','desc')->limit(250)->get();
        }
        //        dd($historique_transactions_waricrowd);
        return view('administrateur/historique_retraits',compact('historique_retraits','date_debut','date_fin'));
    }

//==================================== CONTENU NOTIFICATIONS
    public function definir_contenu_notifications(){
        $la_ligne_notification = SmsContenuNotification::first();
        if($la_ligne_notification == null){
            $la_ligne_notification = new SmsContenuNotification();
            $la_ligne_notification->confirmation_compte = 'Bienvenu(e) sur waribana, votre code de confirmation est le suivant $code$';
            $la_ligne_notification->retard_paiement = 'Bonjour, des cotisations en retard sur la tontine << $titre$ >>; retardataires : $liste_retardataires$ ';
            $la_ligne_notification->etat_waricowd = 'Bonjour votre waricrowd intitule <<$titre$>> a ??t?? : $etat$ $motif$';
            $la_ligne_notification->etat_tontine = 'Bonjour votre tontine intitule <<$titre$>> est : $etat$ $motif$ ';
            $la_ligne_notification->invitation_recue = 'Bonjour, le menbre $nom_complet$ de waribana vous invite a rejoindre la tontine << $titre_tontine$ >>, Connectez vous inscrivez-vous pour repondre a son invitation';
            $la_ligne_notification->virement_compte_menbre_qui_prend = 'Bonjour, montant de cotisation atteinds sur tontine << $titre_tontine$ >>, virement effectue au menbre : $nom_menbre_qui_prend$ ';
            $la_ligne_notification->save();
            $la_ligne_notification = SmsContenuNotification::first();
        }

        return view('administrateur/sms/contenu',compact('la_ligne_notification'));
    }

    public function post_definir_contenu_notifications(Request $request){
        $la_ligne_notification = SmsContenuNotification::firstOrNew();
        $la_ligne_notification->confirmation_compte = $request['confirmation_compte'];
        $la_ligne_notification->etat_tontine = $request['etat_tontine'];
        $la_ligne_notification->etat_waricowd = $request['etat_waricrowd'];
        $la_ligne_notification->retard_paiement = $request['retard_paiement'];
        $la_ligne_notification->invitation_recue = $request['invitation_recue'];
        $la_ligne_notification->virement_compte_menbre_qui_prend = $request['virement_compte_menbre_qui_prend'];
        $la_ligne_notification->save();
        $notification = "<div class='alert alert-success text-center'> Operation bien effectu??e </div>";
        return redirect()->back()->with('notification',$notification);
    }

//=====================================GESTIONNAIRES
    public function les_gestionnaire(){
        // $liste_gestionnaire = User::where('role','!=','super_admin')->get();
        $liste_gestionnaire = User::get();
        return view('administrateur/gestionnaires/index',compact('liste_gestionnaire'));
    }
    
    public function enregistrer_gestionnaire(Request $request){
        $df = $request->input();
        
        $le_gestionnaire = new User();
        $le_gestionnaire->name = $df['nom_complet'];
        $le_gestionnaire->email = $df['email'];
        $le_gestionnaire->role = $df['role'];
        $le_gestionnaire->password = bcrypt('waribana');
        $le_gestionnaire->save();
        
        $notification = "<div class='alert alert-success text-center'> Operation bien effectu??e </div>";
        return redirect()->back()->with('notification',$notification);
    }
    
    
    public function modifier_gestionnaire(Request $request,$id_gestionnaire){
        $df = $request->input();
        
        $le_gestionnaire = User::findOrFail($id_gestionnaire);
        $le_gestionnaire->role = $df['role'];
        $le_gestionnaire->etat = $df['etat'];
        $le_gestionnaire->save();
        
        $notification = "<div class='alert alert-success text-center'> Operation bien effectu??e </div>";
        return redirect()->back()->with('notification',$notification);
    }
    
//==================================== FRAIS DE GESTION
    public function parametre(){
        $les_parametres = Parametre::first();
        if($les_parametres == null){
            $les_parametres = new Parametre();
            $les_parametres->pourcentage_frais =1;
            $les_parametres->save();
        }
        return view('administrateur/frais_de_gestion',compact('les_parametres'));
    }
    
    public function post_parametre(Request $request){
        try{
          $pourcentage_frais = $request->input('pourcentage_frais');
          
            $les_parametres = Parametre::first();
            if($les_parametres == null){
                $les_parametres = new Parametre();
            }
            
            $les_parametres->pourcentage_frais = $pourcentage_frais;
            $les_parametres->save();


            $notification = "<div class='alert alert-success text-center'> Operation bien effectu??e </div>";
        }catch(\Exception $e){
            $notification = "<div class='alert alert-danger text-center'> Un probleme est survenu. </div>";
        }
        return redirect()->back()->with('notification',$notification);
    }
}
