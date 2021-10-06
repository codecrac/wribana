<?php

namespace App\Http\Controllers;

use App\Models\Menbre;
use App\Models\Tontine;
use App\Models\Transaction;
use App\Models\TransactionWaricrowd;
use App\Models\Waricrowd;
use Illuminate\Http\Request;

class CinetpayPaiementController extends Controller
{

    public static $apikey = '164337344557daee019215c2.65958011';
    public static $cpm_site_id = '750304';
    public static $mdp_api_transfert = 'Succes$$2039';

    public static function generer_lien_paiement($le_menbre,$id,$montant_convertit_en_fcfa,$montant,$section="tontine")
    {
        $apikey = CinetpayPaiementController::$apikey ;
        $site_id = CinetpayPaiementController::$cpm_site_id ;
        $transaction_id = 'waribana-'.$section.'-'.time();
        $currency = 'XOF';
        $description = 'PAIEMENT WARIBANA';
        $return_url = "";
        $notify_url = "";

        $customer_phone_number = $le_menbre->telephone;
        $customer_email = $le_menbre->email;
        $customer_address = $le_menbre->adresse;
        $customer_city = $le_menbre->ville;
        $customer_country = $le_menbre->pays;
        $customer_state = $le_menbre->etat_us;
        $customer_zip_code = $le_menbre->code_postal;

        if($section=="tontine"){
            $notify_url = route('notification_paiement_cotisation_tontine');
            $return_url = route('espace_menbre.details_tontine',[$id]).'?trans_id='.$transaction_id;
//            $notify_url = "https://waribana.jeberge.xyz/api/notification_paiement_cotisation_tontine";
        }else{
            //dans ce cas c'est un crowd
            $notify_url = route('notification_paiement_cotisation_crowd');
            $return_url = route('espace_menbre.details_waricrowd',[$id]).'?trans_id='.$transaction_id;
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
            "customer_country" => $le_menbre->pays,
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
//        dd($la_reponse_en_objet->data);

        $la_reponse_en_objet = $la_reponse_en_objet->data;
        $payement_token = $la_reponse_en_objet->payment_token;
        $payment_url = $la_reponse_en_objet->payment_url;

        if($section=="tontine"){ //creer la transaction
            CinetpayPaiementController::preparer_paiement_cotisation($id,$payement_token,$transaction_id);
        }else{
            CinetpayPaiementController::preparer_soutien_waricrowd($id,$montant,$transaction_id);
        }

        return $payment_url;

    }

    public function notification_paiement_cotisation_tontine(Request $request){
        $cpm_trans_id = $request->input('cpm_trans_id');
        $code_reponse_etat_paiement = $this->recup_statut_paiement_cinetpay($cpm_trans_id); // 00 pour succes, le reste pour probleme

        $la_transaction = Transaction::where('trans_id',$cpm_trans_id)->first();

        if($code_reponse_etat_paiement == 0){
            $la_transaction->statut = 'ACCEPTED';
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

    private static function preparer_paiement_cotisation($id_tontine,$token,$trans_id){
        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];

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
        $la_transaction->save();
    }

    private static function preparer_soutien_waricrowd($id_crowd,$montant_soutien,$trans_id){
        $la_session = session(MenbreController::$cle_session);
        $id_menbre_connecter = $la_session['id'];

        $la_transaction = new TransactionWaricrowd();
        $la_transaction->id_waricrowd = $id_crowd;
        $la_transaction->id_menbre = $id_menbre_connecter;
        $la_transaction->montant = $montant_soutien;
        $la_transaction->statut = "PENDING";
        $la_transaction->trans_id = $trans_id;
        $la_transaction->save();
    }

}
