<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CahierRetraitSoldeMenbre;
use App\Models\Menbre;

class CinetpayApiTransfertController extends Controller
{
//================================API TRANSFERT=============================
    public static function recuperer_token_api_tranfert()
    {
        $apikey = \App\Http\Controllers\NotificationPaiementCinetPay::$apikey;
        $mdp_api_transfert = \App\Http\Controllers\NotificationPaiementCinetPay::$mdp_api_transfert;
        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://client.cinetpay.com/v1/auth/login',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'apikey=' . $apikey . '&password=' . $mdp_api_transfert,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
        $reponse_in_json = json_decode($response);
        $token = $reponse_in_json->data->token;
        return $token;
    }

    public static function recuperer_le_solde_du_compte_cinetpay()
    {
        //Credentials apiKey & mdp
        $token = CinetpayApiTransfertController::recuperer_token_api_tranfert();

        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://client.cinetpay.com/v1/transfer/check/balance?token=' . $token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);

        $reponse_in_json = json_decode($response);
        $solde = $reponse_in_json->data->amount;
        return $reponse_in_json;
    }

    public static function ajouter_un_contact($data_json,$token)
    {

    //   $data_json = 'data=[{ "prefix":"225", "phone":"0778735784","name":"yves","surname":"ladde","email":"yvessantoz@exemple.com" }]';
//     dd($data_json);

         $curl = curl_init();
           curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://client.cinetpay.com/v1/transfer/contact?token='.$token,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_POSTFIELDS => $data_json,
                CURLOPT_CUSTOMREQUEST => 'POST',

            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
//        echo $response;
//        dd($response);
        return $response;
    }


    public static function effectuer_un_retrait($le_menbre,$montant_retirer)
    {
        $nom = $le_menbre->nom_complet;
        $prenom = $nom;
        $tableau = explode(" ",$nom);
        if(sizeof($tableau) >1){
            $nom = $tableau[0];
            $prenom = $tableau[1];
        }
        
        $telephone = $le_menbre->telephone;
        
        $prefixe = CountryPrefixController::getPrefix($le_menbre->pays);
        $telephone = str_replace($prefixe,'',$telephone);
        //dd($le_menbre->pays,$le_menbre->pays,$telephone);
        
        $email = $le_menbre->email;
        if(empty($email)){
            $email ="user".$le_menbre->id."waribana.net";
        }
        $data_json = 'data=[{ "prefix":"'.$prefixe.'", "phone":"'.$telephone.'","name":"'.$nom.'","surname":"'.$prenom.'","email":"'.$email.'" }]';

        $token = CinetpayApiTransfertController::recuperer_token_api_tranfert();
        
        $pp = CinetpayApiTransfertController::ajouter_un_contact($data_json,$token);
        //dd($pp);

        $notify_url = route('api.notification_retrait_compte_client');
        // dd($notify_url);
        $notify_url = "http://waribana.jeberge.xyz/api/retour-retrait-compte-menbre/reponse-cinetpay";
        $trans_id = "retrait-".time();

        // $data = json_encode( array(
        //     "prefix" => $prefixe,
        //     "phone" => $telephone,
        //     "amount" => $montant_retirer,
        //     "notify_url" => $notify_url,
        //     "client_transaction_id" => $trans_id
        // ));

        $data_json = 'data=[{ "prefix":"'.$prefixe.'", "phone":"'.$telephone.'","amount":"'.$montant_retirer.'","notify_url":"'.$notify_url.'","client_transaction_id":"'.$trans_id.'" }]';
        // $data_json = "['data'=[$data]]";
        // dd($data_json);

        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://client.cinetpay.com/v1/transfer/money/send/contact?token='. $token.'&lang=fr',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_POSTFIELDS => $data_json,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        
       // dd($response);
        return $response;
        
        
    }

    public function notification_retrait_compte_client(Request $request){
        return "ok";
    }


    
    public static function enregistrer_retrait($le_menbre,$montant_retirer){

        
        $solde_avant_retrait = $le_menbre->compte->solde;
        $solde_apres_retrait = $le_menbre->compte->solde - $montant_retirer;
        
        //mettre le compte a jour
        $le_menbre->compte->solde = $solde_apres_retrait;
        $le_compte = $le_menbre->compte;
        $le_compte->save();
        
        //garder une trace de la transaction
        $le_retrait = new CahierRetraitSoldeMenbre();
        $le_retrait->id_menbre = $le_menbre->id;
        $le_retrait->montant_retirer = $montant_retirer;
        $le_retrait->solde_avant = $solde_avant_retrait;
        $le_retrait->solde_apres = $solde_apres_retrait;
        $le_retrait->statut = "ACCEPTED";
        $le_retrait->save();

    }



}
