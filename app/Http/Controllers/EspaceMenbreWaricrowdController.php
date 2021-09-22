<?php

namespace App\Http\Controllers;

use App\Models\CaisseWaricrowd;
use App\Models\CategorieWaricrowd;
use App\Models\Menbre;
use App\Models\TransactionWaricrowd;
use App\Models\Waricrowd;
use App\Models\WaricrowdMenbre;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\PHPMailer;

class EspaceMenbreWaricrowdController extends Controller
{



    public  function  liste_waricrowd(){

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $le_menbre = Menbre::find($id_menbre_connecter);
        $liste_waricrowd = $le_menbre->mes_waricrowd;
//        dd($liste_waricrowd);
        return view('espace_menbre/waricrowd/liste',compact('liste_waricrowd'));
    }

    public function creer_un_waricrowd(){
        $liste_categorie_waricrowd = CategorieWaricrowd::all();
        return view('espace_menbre/waricrowd/ajouter',compact('liste_categorie_waricrowd'));
    }
    public function editer_crowd($id_crowd){
        $le_crowd = Waricrowd::find($id_crowd);
        $liste_categorie_waricrowd = CategorieWaricrowd::all();
        return view('espace_menbre/waricrowd/editer',compact('le_crowd','liste_categorie_waricrowd'));
    }

    public function enregistrer_un_waricrowd(Request $request){
        $donnees_formulaire = $request->all();
        $id_categorie_waricrowd = $donnees_formulaire['id_categorie_waricrowd'];
        $titre = $donnees_formulaire['titre'];
        $description_courte = $donnees_formulaire['description_courte'];
        $description_complete = $donnees_formulaire['description_complete'];
        $montant_objectif = $donnees_formulaire['montant_objectif'];
        $pitch_video = $this->formaterLienPitch($donnees_formulaire['lien_pitch_video']);

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];

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
//            dd("have file");
            $uploaddir = public_path('images/waricrowd/');
            $nom_image_illustration = 'images/waricrowd/'. basename($_FILES['image_illustration']['name']);
            move_uploaded_file($_FILES['image_illustration']['tmp_name'], $nom_image_illustration);

//            $nom_image_illustration = time().'.'.request()->img->getClientOriginalExtension();
//            dd($nom_image_illustration);
//            $image->move(public_path('images/waricrowd'), $nom_image_illustration);
            $le_crowd->image_illustration = $nom_image_illustration;
        }

//dd("no file");
        if($le_crowd->save()){
            //creer la caisse qui va avec
            $la_caisse_de_crowd = CaisseWaricrowd::findOrNew($le_crowd->id);
            $la_caisse_de_crowd->id_waricrowd = $le_crowd->id;
            $la_caisse_de_crowd->montant_objectif = $montant_objectif;
            $la_caisse_de_crowd->montant = 0;
            $la_caisse_de_crowd->save();

            $notification = "<div class='alert alert-success text-center'> Operation effectuée avec succes </div>";
        }else{
            $notification = "<div class='alert alert-danger text-center'> Quelquechose s'est mal passée, veuillez rééssayer </div>";
        }

        return redirect()->back()->with("notification",$notification);
    }

    public function modifier_un_waricrowd(Request $request,$id_crowd){
        $donnees_formulaire = $request->all();

        $id_categorie_waricrowd = $donnees_formulaire['id_categorie_waricrowd'];
        $titre = $donnees_formulaire['titre'];
        $description_courte = $donnees_formulaire['description_courte'];
        $description_complete = $donnees_formulaire['description_complete'];
        $montant_objectif = $donnees_formulaire['montant_objectif'];
        $pitch_video = $this->formaterLienPitch($donnees_formulaire['lien_pitch_video']);

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];

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
//            dd("have file");
            $uploaddir = public_path('images/waricrowd/');
            $nom_image_illustration = 'images/waricrowd/'. basename($_FILES['image_illustration']['name']);
            move_uploaded_file($_FILES['image_illustration']['tmp_name'], $nom_image_illustration);

            $le_crowd->image_illustration = $nom_image_illustration;
        }

//dd("no file");
        if($le_crowd->save()){
            //creer la caisse qui va avec
            $la_caisse_de_crowd = CaisseWaricrowd::findOrNew($le_crowd->id);
            $la_caisse_de_crowd->id_waricrowd = $le_crowd->id;
            $la_caisse_de_crowd->montant_objectif = $montant_objectif;
            $la_caisse_de_crowd->save();

            $notification = "<div class='alert alert-success text-center'> Operation effectuée avec succes </div>";
        }else{
            $notification = "<div class='alert alert-danger text-center'> Quelquechose s'est mal passée, veuillez rééssayer </div>";
        }

        return redirect()->back()->with("notification",$notification);
    }

    public function details_waricrowd($id_crowd){
        $le_crowd = Waricrowd::find($id_crowd);
        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $mes_transactions_pour_ce_crowd = TransactionWaricrowd::where('id_menbre','=',$id_menbre_connecter)->where('id_waricrowd','=',$id_crowd)->get();
        return view('espace_menbre/waricrowd/details',compact('le_crowd','mes_transactions_pour_ce_crowd'));
    }


//    ================================================Utilitaire
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

    public function soutenir_projet(Request $request,$id_crowd){

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];

        $donnees_formulaire = $request->all();
        $montant_soutien = $donnees_formulaire['montant_soutien'];

        $la_transaction = new TransactionWaricrowd();
        $la_transaction->id_menbre = $id_menbre_connecter;
        $la_transaction->id_waricrowd = $id_crowd;
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

            $notification = "<div class='alert alert-success text-center'> Operation bien effectuee </div>";

            $le_menbre = Menbre::find($id_menbre_connecter);
            $le_crowd = Waricrowd::find($id_crowd);
            $infos_pour_recu = [
                'nom_complet'=>$le_menbre->nom_complet,
                'email_souteneur'=>$le_menbre->email,
                'type_section'=>'tontine',
                'montant'=>$montant_soutien,
                'titre_waricrowd'=>$le_crowd->titre,
                'nom_createur_waricrowd'=>$le_crowd->createur->nom_complet];
            $this->recu_de_paiement_waricrowd($infos_pour_recu);

        }else{
            $notification = "<div class='alert alert-danger text-center'> Quelque chose s'est mal passé </div>";
        }

        return redirect()->back()->with('notification',$notification);
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


    public function projets_soutenus(){
        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];

        $le_menbre = Menbre::find($id_menbre_connecter);
        $projets_soutenus = $le_menbre->projets_soutenus;
//        dd($projets_soutenus);
        return view('espace_menbre/waricrowd/projets_soutenus',compact('projets_soutenus'));
    }



    //===============================================UTILITAIRE
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
}
