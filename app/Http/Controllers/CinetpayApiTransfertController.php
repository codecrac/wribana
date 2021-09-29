<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CinetpayApiTransfertController extends Controller
{
//================================API TRANSFERT=============================
    public static function recuperer_token_api_tranfert()
    {
        //Credentials apiKey & mdp
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
        return $solde;
    }

    public static function ajouter_un_contact()
    {
        $apikey = \App\Http\Controllers\NotificationPaiementCinetPay::$apikey;
        $mdp_api_transfert = \App\Http\Controllers\NotificationPaiementCinetPay::$mdp_api_transfert;
        //Credentials apiKey & mdp
        $token = CinetpayApiTransfertController::recuperer_token_api_tranfert();
        //  dd($token);

        $prefix ='225';
        $phone ='55994041';
        $name ='name';
        $surname ='surname';
        $email ='yvessantoz@gmail.com';

        $data_json = 'prefix='.$prefix .'&phone='. $phone.'&name='.$name.'&surname='.$surname.'&email='.$email;

        $curl = curl_init();
        curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://client.cinetpay.com/v1/transfer/contact?token='.$token.'&lang=fr',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_POSTFIELDS => 'prefix='.$prefix .'&phone='. $phone.'&name='.$name.'&surname='.$surname.'&email='.$email,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        dd($response);

        $reponse_in_json = json_decode($response);
        $solde = $reponse_in_json->data->amount;
        return $solde;
    }


    public static function effectuer_un_retrait()
    {
        $token = CinetpayApiTransfertController::recuperer_token_api_tranfert();
        $prefix ='225';$phone ='55994041';$amount ='100';$notify_url ='100';$client_transaction_id ='100';

        $data_json = json_encode( array( 'prefix' => $prefix,'phone' => $phone,
                                    'amount' => $amount,'notify_url' => $notify_url,'client_transaction_id' => $client_transaction_id,
                                ));

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

        $response = curl_exec($curl); curl_close($curl);
        dd($response);

        $reponse_in_json = json_decode($response);
        $solde = $reponse_in_json->data->amount;
        return $solde;
    }
}
