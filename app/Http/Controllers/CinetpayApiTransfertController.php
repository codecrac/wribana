<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
//        dd($token);
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
//        dd($response);
        $reponse_in_json = json_decode($response);
        $solde = $reponse_in_json->data->amount;
        return $reponse_in_json;
    }

    public static function ajouter_un_contact($token)
    {

       $data_json = 'data=[{ "prefix":"225", "phone":"0778735784","name":"yves","surname":"ladde","email":"yvessantoz@exemple.com" }]';
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
        echo $response;
//        dd($response);
    }


    public static function effectuer_un_retrait($le_menbre)
    {
        $nom = $le_menbre->nom_complet;
        $telephone = $le_menbre->telephone;
        $email = $le_menbre->telephone;
        $data_json = 'data=[{ "prefix":"225", "phone":"'.$telephone.'","name":"'.$nom.'","surname":"","email":"'.$email.'" }]';

        $token = CinetpayApiTransfertController::recuperer_token_api_tranfert();
        CinetpayApiTransfertController::ajouter_un_contact($data_json,$token);

        $notify_url = "http://waribana.jeberge.xyz/api/retour-retrait";
        $data_json = 'data=[{ "prefix":"225", "phone":"'.$telephone.'","amount":"100","notify_url":"'.$notify_url.'","client_transaction_id":"'.time().'" }]';

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
        return $response;

       /* die();
        $reponse_in_json = json_decode($response);
        $solde = $reponse_in_json->data->amount;
        return $solde;*/
    }
}
