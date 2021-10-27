<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class InvitationController extends Controller
{
    
    public function inviter_des_amis($id_tontine){
        $la_tontine = Tontine::find($id_tontine);
        if($la_tontine == null){
            return redirect()->route('espace_menbre.liste_tontine');
        }
        return view("espace_menbre/tontine/inviter_des_amis",compact("la_tontine"));
    }

    public function envoyer_invitation_via_sms(Request $request,$id_tontine)
    {
        $donnees_formulaire = $request->all();
        $prefixe = $donnees_formulaire['prefixe'];
        $telephone = $donnees_formulaire['telephone'];
        $le_numero = $prefixe . $telephone;

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $le_menbre = Menbre::find($id_menbre_connecter);
        $nom_complet = $le_menbre->nom_complet;

        $la_tontine = Tontine::find($id_tontine);
        $titre = $la_tontine->titre;

        $adresse =  "https://" . $_SERVER['SERVER_NAME'] .'/espace-menbre/invitations';
        $message = " Bonjour, le menbre $nom_complet de waribana vous invite a rejoindre la tontine <<$titre>>,Connectez vous inscrivez-vous pour repondre a son invitation; $adresse";

        // dd($le_numero);
        $reponse = SmsController::sms_info_bip($le_numero,$message);
        // dd($reponse);

        
        $une_invitation = new Invitation();
        $une_invitation->id_tontine = $id_tontine;
        $une_invitation->email_inviter = $le_numero;
        $une_invitation->menbre_qui_invite = $id_menbre_connecter;
        $une_invitation->etat = "invitation envoyee";
        $une_invitation->save();
        $notification = "<div class='alert alert-success text-center'> Operatin bien éffectuée </div>";
        return redirect()->back()->with('notification',$notification);
    }

    public function envoyer_invitation(Request $request,$id_tontine){
        $donnees_formulaire = $request->all();

        $adresse =  "https://" . $_SERVER['SERVER_NAME'] .'/espace-menbre/invitations';

        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];
        $le_menbre = Menbre::find($id_menbre_connecter);
        $nom_complet = $le_menbre->nom_complet;

        $la_tontine = Tontine::find($id_tontine);
        $titre = $la_tontine->titre;
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
                        $adresse
            ",$headers
        );


      /*  $telephone = $la_tontine->createur->telephone;

        $contenu_notification = SmsContenuNotification::first();
        $message_notif = $contenu_notification['invitation_recue'];
        $le_message = str_replace('$nom_complet$',$nom_complet,$message_notif);
        $le_message = str_replace('$titre_tontine$',$la_tontine->titre,$message_notif);
        SmsController::sms_info_bip($telephone,$le_message);*/

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
        $telephone_inviter = $le_menbre['telephone'];


        $invitation_recues = [];
        if($email_inviter!=null){
            $invitation_recues = Invitation::where('email_inviter','=',$email_inviter)->orWhere('email_inviter','=',$telephone_inviter)->where('etat','=','attente')->get();
        }
        return view("espace_menbre/tontine/invitations",compact('invitation_recues'));
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
                $notification = " <div class='alert alert-danger text-center'> Le nombre de participant est dejà atteint</div>";
            }else{
                $notification = " <div class='alert alert-success text-center'> Operation bien effectuée </div>";
            }
        }

        return redirect()->back()->with('notification',$notification);
    }

    public function confirmer_adhesion_tontine(Request $request){
        $donnees_formulaires = $request->all();
        $code_invitation = $donnees_formulaires['code_invitation'];

        $la_tontine = Tontine::where('identifiant_adhesion','=',$code_invitation)->first();
        $notification = "<div class='alert alert-danger text-center'> Code d'adhesion invalide </div>";

        if($la_tontine != null){
            
            $la_session = session(MenbreController::$cle_session);
            $id_menbre_connecter = $la_session['id'];
            $deja_menbre = MenbreTontine::where('menbre_id','=',$id_menbre_connecter)->where('tontine_id','=',$la_tontine->id)->first();
            if($deja_menbre!=null){
                $notification = " <div class='alert alert-danger text-center'> Vous êtes deja un menbre de cette tontine  </div>";
            }else{
                return view('espace_menbre/tontine/confirmer_adhesion_tontine',compact('la_tontine'));
            }
        }

        return redirect()->back()->with('notification',$notification);
    }

    public function adhesion_via_code_invitation(Request $request){

        $donnees_formulaires = $request->all();
        $code_invitation = $donnees_formulaires['code_invitation'];

        $la_tontine = Tontine::where('identifiant_adhesion','=',$code_invitation)->first();

        if($la_tontine ==null){
            $notification = " <div class='alert alert-danger text-center'> Ce code est invalide</div>";
        }else{

            $la_session = session(MenbreController::$cle_session);
            $id_menbre_connecter = $la_session['id'];

            $deja_menbre = MenbreTontine::where('menbre_id','=',$id_menbre_connecter)->where('tontine_id','=',$la_tontine->id)->first();
            if($deja_menbre==null){
                if(sizeof($la_tontine->participants) < $la_tontine->nombre_participant){

                    $nouveau_menbre = new MenbreTontine();
                    $nouveau_menbre->tontine_id = $la_tontine->id;
                    $nouveau_menbre->menbre_id = $id_menbre_connecter;
                    $nouveau_menbre->save();

                    $notification = " <div class='alert alert-success text-center'> Operation bien effectuée </div>";


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
                    return redirect()->route('espace_menbre.details_tontine',[$la_tontine->id])->with('notification',$notification);
                }else{
                    $notification = " <div class='alert alert-danger text-center'> Le nombre de participant est dejà atteint</div>";
                }

            }else{
                $notification = " <div class='alert alert-danger text-center'> Vous êtes deja un menbre de cette tontine  </div>";
            }


        }


        return redirect()->back()->with('notification',$notification);
    }

   
}
