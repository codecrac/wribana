<?php

namespace App\Http\Controllers;

use App\Models\Menbre;
use App\Models\Tontine;
use App\Models\Transaction;
use App\Models\TransactionWaricrowd;
use App\Models\CahierCompteTontine;
use App\Models\Waricrowd;
use App\Models\CompteMenbre;
use App\Models\CaisseTontine;
use App\Models\SmsContenuNotification;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\EspaceMenbreWaricrowdController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class CinetpayPaiementController extends Controller
{

    public static $apikey = '164337344557daee019215c2.65958011';
    public static $cpm_site_id = '750304';
    public static $mdp_api_transfert = 'Succes$$2039';

    public static function generer_lien_paiement($le_menbre,$id,$montant_convertit_en_fcfa,
    $montant,$section="tontine",$route_back_en_cas_derreur,$from_mobile=false)
    {
        $apikey = CinetpayPaiementController::$apikey ;
        $site_id = CinetpayPaiementController::$cpm_site_id ;
        $transaction_id = 'waribana-'.$section.'-'.time();
        $currency = 'XOF';
        $description = 'PAIEMENT WARIBANA';
        $return_url = "";
        $notify_url = "";


        if($section=="tontine"){
            $notify_url = route('notification_paiement_cotisation_tontine');
            $return_url = route('api.details_tontine',[$id]).'?trans_id='.$transaction_id;

            
            if($from_mobile){
                $return_url = route('api.mobile.statut_transaction').'?trans_id='.$transaction_id;
            }
//            $notify_url = "https://waribana.jeberge.xyz/api/notification_paiement_cotisation_tontine";
        }else{
            //dans ce cas c'est un crowd
            $notify_url = route('notification_paiement_cotisation_crowd');
            $return_url = route('api.details_waricrowd',[$id]).'?trans_id='.$transaction_id;

             
            if($from_mobile){
                $return_url = route('api.mobile.statut_transaction').'?trans_id='.$transaction_id;
            }
//            $notify_url = "https://waribana.jeberge.xyz/api/notification_paiement_cotisation_crowd";
        }
//        dd($notify_url);

        $nom_complet_eclater = explode(' ',$le_menbre->nom_complet);
        $nom = $nom_complet_eclater[0];
        if(isset($nom_complet_eclater[1])){
            unset($nom_complet_eclater[0]);
            $prenom = implode(' ',$nom_complet_eclater);
        }else{
            $prenom = "";
        }

        // dd($nom,$prenom);
        $url_pour_generer = "https://api-checkout.cinetpay.com/v2/payment";
        $data = array(
            "apikey" => $apikey,
            "site_id" => $site_id,
            "transaction_id" => $transaction_id,
            "amount" => round($montant_convertit_en_fcfa),
            "currency" => $currency,
            "description" => $description,
            "return_url" => $return_url,
            "notify_url" => $notify_url,

            "customer_name" => $nom,
            "customer_surname" => $prenom,
            "customer_phone_number" => $le_menbre->telephone,
            "customer_email" => $le_menbre->email,
            "customer_address" => $le_menbre->adresse,
            "customer_city" => $le_menbre->ville,
            "customer_country" => strtoupper($le_menbre->pays),
            "customer_zip_code" => $le_menbre->code_postal,
        );

        if($le_menbre->etat_us !=null){
            $data["customer_state"] = $le_menbre->etat_us;
        }
        if($le_menbre->code_postal ==null){
            $data["customer_zip_code"] = "00225";
        }

        $data_json = json_encode($data);
    //    echo $data_json;
        // die(); 

        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => $url_pour_generer,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_POSTFIELDS => $data_json,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        $la_reponse_en_objet = json_decode($response);
    //    dd($la_reponse_en_objet);


       if(!isset($la_reponse_en_objet->data)){ //on a un probleme
            $notification = "Erreur : $la_reponse_en_objet->description;  (FCFA, XOF)";
            // dd($route_back_en_cas_derreur);
            return "$route_back_en_cas_derreur?probleme_lien_paiement=$notification";
       }
        $la_reponse_en_objet = $la_reponse_en_objet->data;
        $payement_token = $la_reponse_en_objet->payment_token;
        $payment_url = $la_reponse_en_objet->payment_url;

        if($section=="tontine"){ //creer la transaction
            CinetpayPaiementController::preparer_paiement_cotisation($le_menbre->id,$id,$payement_token,$transaction_id);
        }else{
            CinetpayPaiementController::preparer_soutien_waricrowd($le_menbre->id,$id,$montant,$transaction_id);
        }

        return $payment_url;

    }

    public function notification_paiement_cotisation_tontine(Request $request){
        $cpm_trans_id = $request->input('cpm_trans_id');
        if($cpm_trans_id == null){
            $cpm_trans_id = "waribana-tontine-1633710459";
        }
        $code_reponse_etat_paiement = $this->recup_statut_paiement_cinetpay($cpm_trans_id); // 00 pour succes, le reste pour probleme

        $la_transaction = Transaction::where('trans_id',$cpm_trans_id)->first();

        if($code_reponse_etat_paiement == 0){
            $la_transaction->statut = 'ACCEPTED';
            CinetpayPaiementController::paiement_cotisation_reussie($la_transaction);
        }else{
            $la_transaction->statut = 'REFUSED';
        }
        $la_transaction->save();
        return true;
    }

    public function notification_paiement_cotisation_crowd(Request $request){
        $cpm_trans_id = $request->input('cpm_trans_id');
        $code_reponse_etat_paiement = $this->recup_statut_paiement_cinetpay($cpm_trans_id); // 00 pour succes, le reste pour probleme

        $la_transaction = TransactionWaricrowd::where('trans_id',$cpm_trans_id)->first();

        if($code_reponse_etat_paiement == 0){
            $la_transaction->statut = 'ACCEPTED';
        }else{
            $la_transaction->statut = 'REFUSED';
        }
        $la_transaction->save();
        return true;
    }


    public function recup_statut_paiement_cinetpay($cpm_trans_id='waribana-1633451811',$section="tontine")
    {
        $apikey = CinetpayPaiementController::$apikey ;
        $site_id = CinetpayPaiementController::$cpm_site_id ;
        $transaction_id = $cpm_trans_id;

        if($section=="tontine"){
            $notify_url = route('notification_paiement_cotisation_tontine');
        }
//        dd($notify_url);

        $url_pour_recuperer = "https://api-checkout.cinetpay.com/v2/payment/check";
        $data = array(
            "apikey" => $apikey,
            "site_id" => $site_id,
            "transaction_id" => $transaction_id
        );

        $data_json = json_encode($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => $url_pour_recuperer,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_POSTFIELDS => $data_json,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        $response_in_json = json_decode($response);

        return $response_in_json->code;

    }

    private static function preparer_paiement_cotisation($id_menbre_connecter,$id_tontine,$token,$trans_id){
        $la_tontine = Tontine::find($id_tontine);
        $montant = $la_tontine->montant;

        $la_transaction = new Transaction();
        $la_transaction->id_tontine = $id_tontine;
        $la_transaction->id_menbre = $id_menbre_connecter;
        $la_transaction->montant = $montant;
        $la_transaction->statut = "PENDING";
        $la_transaction->trans_id = $trans_id;
        $la_transaction->token = $token;
        $la_transaction->id_menbre_qui_prend = $la_tontine->caisse->menbre_qui_prend->id;
        $la_transaction->index_ouverture = $la_tontine->caisse->index_ouverture;
        $la_transaction->save();
    }
    
    private static function paiement_cotisation_reussie($la_transaction){
        
        $id_tontine = $la_transaction->id_tontine;
        $montant = $la_transaction->montant;
        
        $la_tontine = Tontine::find($id_tontine);
        $le_menbre = Menbre::find($la_transaction->id_menbre);
        
         $la_caisse_de_la_tontine = CaisseTontine::findOrNew($id_tontine);
            $la_caisse_de_la_tontine->id_tontine= $id_tontine;
            $nouveau_montant = $la_caisse_de_la_tontine->montant;
            $nouveau_montant += $la_tontine->montant;
            $la_caisse_de_la_tontine->montant = $nouveau_montant;

            $la_caisse_de_la_tontine->save();
 
            $maintenant = date('d/m/Y H:i', strtotime(now()));
//            dd($maintenant);
            $liste_participants = $la_tontine->participants;
//            dd($liste_participants);
            CinetpayPaiementController::notifier_paiement_cotisation($liste_participants,$le_menbre->nom_complet,$montant,$la_tontine->createur->devise_choisie->monaie,$la_tontine->titre,$maintenant);

            if($le_menbre->email !=null){
                $infos_pour_recu = ['nom_complet'=>$le_menbre->nom_complet,
                    "email_destinataire"=>$le_menbre->email,
                    'type_section'=>'tontine',
                    'montant'=>$la_tontine->montant,
                    'titre_tontine'=>$la_tontine->titre,
                    'nom_menbre_qui_prend'=>$la_tontine->caisse->menbre_qui_prend->nom_complet];

                CinetpayPaiementController::recu_de_paiement_tontine($infos_pour_recu);
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

                    $numero = $item_participant->telephone;
                    SmsController::sms_info_bip($numero,$message);
                     $headers = 'From: no-reply@waribana.net' . "\r\n" .
                     'Reply-To: no-reply@waribana.net' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();
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

    private static function preparer_soutien_waricrowd($id_menbre_connecter,$id_crowd,$montant_soutien,$trans_id){
        $la_transaction = new TransactionWaricrowd();
        $la_transaction->id_waricrowd = $id_crowd;
        $la_transaction->id_menbre = $id_menbre_connecter;
        $la_transaction->montant = $montant_soutien;
        $la_transaction->statut = "PENDING";
        $la_transaction->trans_id = $trans_id;
        $la_transaction->save();
    }
    
    

//=========================FONCTION UTILITAIRE
     private static function notifier_paiement_cotisation($liste_participants,$nom_cotiseur,$montant_cotisation,$devise,$titre_de_la_tontine,$date_paiement){
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

     public static function recu_de_paiement_tontine($infos_pour_recu){
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

}
