<?php

namespace App\Http\Controllers;

use App\Models\Menbre;
use App\Models\TransactionRechargementWaribank;
use App\Models\CompteMenbre;
use App\Models\SmsContenuNotification;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\EspaceMenbreWaricrowdController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CinetpayPaiementController extends Controller
{

    public static $apikey = '164337344557daee019215c2.65958011';
    public static $cpm_site_id = '750304';
    public static $mdp_api_transfert = 'Succes$$2039';

    public static function generer_lien_paiement($le_menbre,$montant_convertit_en_fcfa,
             $montant,$route_back_en_cas_derreur,$from_mobile=false)
    {
        $apikey = CinetpayPaiementController::$apikey ;
        $site_id = CinetpayPaiementController::$cpm_site_id ;
        $transaction_id = 'waribana-rechargement-'.time();
        $currency = 'XOF';
        $description = 'RECHARGEMENT WARIBANA';
        $return_url = "";
        $notify_url = "";


        $notify_url = route('api.notification_paiement_rechargement');
        $return_url = route('api.retour_rechargement_waribank',[$le_menbre->id]).'?trans_id='.$transaction_id;

        
        if($from_mobile){
            $return_url = route('api.mobile.statut_transaction').'?trans_id='.$transaction_id;
        }
        

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
            // on renvoi lurl de l'erreur
            return "$route_back_en_cas_derreur?probleme_lien_paiement=$notification";
       }
        $la_reponse_en_objet = $la_reponse_en_objet->data;
        $payement_token = $la_reponse_en_objet->payment_token;
        $payment_url = $la_reponse_en_objet->payment_url;

        CinetpayPaiementController::preparer_paiement_rechargement($le_menbre,$montant,$transaction_id);
       
        return $payment_url;

    }

    public function notification_paiement_rechargement(Request $request){
        $cpm_trans_id = $request->input('cpm_trans_id');
        if($cpm_trans_id == null){
            $cpm_trans_id = "waribana-rechargement1634987572";
        }
        $code_reponse_etat_paiement = $this->recup_statut_paiement_cinetpay($cpm_trans_id); // 00 pour succes, le reste pour probleme

        $la_transaction = TransactionRechargementWaribank::where('trans_id',$cpm_trans_id)->first();

        if($la_transaction->statut == "PENDING"){ //l'api peut etre appeler plusieur fois par cinetpay eviter d'enregistrer le paiement plusieurs fois
            if($code_reponse_etat_paiement == 0){
                $la_transaction->statut = 'ACCEPTED';
                CinetpayPaiementController::paiement_rechargement_reussie($la_transaction);
            }else{
                $la_transaction->statut = 'REFUSED';
            }
            $la_transaction->save();
            return true;
        }
        
    }


    public function recup_statut_paiement_cinetpay($cpm_trans_id='waribana-rechargement1634987572',$section="tontine")
    {
        $apikey = CinetpayPaiementController::$apikey ;
        $site_id = CinetpayPaiementController::$cpm_site_id ;
        $transaction_id = $cpm_trans_id;

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

    private static function preparer_paiement_rechargement($le_menbre,$montant,$trans_id){
        $la_transaction = new TransactionRechargementWaribank();
        $la_transaction->id_menbre = $le_menbre->id;
        $la_transaction->solde_avant = $le_menbre->compte->solde;
        $la_transaction->montant = $montant;
        $la_transaction->solde_apres = $le_menbre->compte->solde + $montant;
        $la_transaction->statut = "PENDING";
        $la_transaction->trans_id = $trans_id;
        $la_transaction->save();
    }
    
    private static function paiement_rechargement_reussie($la_transaction){
        
        $le_menbre = Menbre::find($la_transaction->id_menbre);
        $le_montant = $la_transaction->montant;

        $wallet_menbre =  $le_menbre->compte;
        $wallet_menbre->solde = $wallet_menbre->solde + $le_montant;
        $wallet_menbre->save();
    }

}
