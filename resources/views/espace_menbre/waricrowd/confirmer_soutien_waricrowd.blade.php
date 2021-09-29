<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

    //========================================================utile pour cinetpay
//Credentials apiKey & siteId
$apikey = \App\Http\Controllers\NotificationPaiementCinetPay::$apikey;
$cpm_site_id = \App\Http\Controllers\NotificationPaiementCinetPay::$cpm_site_id;


//Post Parameters
$cpm_version = 'V1';
$cpm_language = 'fr';
$cpm_currency = 'CFA';
$cpm_page_action = 'PAYMENT';
$cpm_payment_config = 'SINGLE';
$cpSecure = "https://secure.cinetpay.com";
$signatureUrl = "https://api.cinetpay.com/v1/?method=getSignatureByPost";
/////////////////////////////

$cpm_amount = $montant_soutien; //TransactionAmount
$cpm_custom = "$notre_custom_field";// This field exist soanything can be inserted in it;it will be send back after payment

$cpm_designation = 'waribana-transaction'; //this field exist to identify the article being paid


$cpm_trans_date = date("Y-m-d H:i:s");
$cpm_trans_id = 'waribana-waricrowd-transaction-' . (string)date("YmdHis"); //Transaction id that will be send to identify the transaction
$return_url = "https://waribana.jeberge.xyz/api/retour-paiement-soutenir-waricrowd/reponse-cinietpay"; //The customer will be redirect on this page after successful payment
$cancel_url = "https://waribana.jeberge.xyz";//The customer will be redirect on this page if the payment get cancel
$notify_url = "https://waribana.jeberge.xyz/api/retour-paiement-soutenir-waricrowd/reponse-cinietpay";//This page must be a webhook (webservice).
//it will be called weither or nor the payment is success or failed
//you must only listen to this to update transactions status


//Data that will be send in the form
$getSignatureData = array(
    'apikey' => $apikey,
    'cpm_amount' => $cpm_amount,
    'cpm_custom' => $cpm_custom,
    'cpm_site_id' => $cpm_site_id,
    'cpm_version' => $cpm_version,
    'cpm_currency' => $cpm_currency,
    'cpm_trans_id' => $cpm_trans_id,
    'cpm_language' => $cpm_language,
    'cpm_trans_date' => $cpm_trans_date,
    'cpm_page_action' => $cpm_page_action,
    'cpm_designation' => $cpm_designation,
    'cpm_payment_config' => $cpm_payment_config
);
// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'method' => "POST",
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query($getSignatureData)
        )
);

$context = stream_context_create($options);
$result = file_get_contents($signatureUrl, false, $context);
if ($result === false) {
    /* Handle error */
    \header($return_url);
    exit();
}
// var_dump($getSignatureData);
// echo("\n");
$signature = json_decode($result);
//var_dump($signature);


?>


@extends('espace_menbre.base_espace_menbre')


@section('content')

    <div class="row">
        <div class=" col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Confirmer votre soutien</h4>
                    <p class="card-description">
                        <!--Lancer une collecte de fond pour realiser mon projet-->
                    </p>
                    <h5>WARICROWD : {{ $le_crowd->titre }}</h5>
                    <h5>Objectif : {{ number_format($le_crowd->caisse->montant_objectif,0,',',' ')  }} F</h5>
                    <h5>Montant atteinds : {{ number_format( $le_crowd->caisse->montant,0,',',' ') }} F</h5>
                    <h5>Votre soutien : {{ number_format($montant_soutien,0,',',' ') }} F</h5>

                    <form action="<?php echo $cpSecure; ?>" method="post">
                                    @csrf

        <input type="hidden" value="<?php echo $apikey; ?>" name="apikey">
        <p><input type="hidden" value="<?php echo $cpm_amount; ?>" name="cpm_amount"></p>
        <input type="hidden" value="<?php echo $cpm_custom; ?>" name="cpm_custom">
        <input type="hidden" value="<?php echo $cpm_site_id; ?>" name="cpm_site_id">
        <input type="hidden" value="<?php echo $cpm_version; ?>" name="cpm_version">
        <p><input type="hidden" value="<?php echo $cpm_currency; ?>" name="cpm_currency"></p>
        <input type="hidden" value="<?php echo $cpm_trans_id; ?>" name="cpm_trans_id">
        <input type="hidden" value="<?php echo $cpm_language; ?>" name="cpm_language">
        <input type="hidden" value="<?php echo $getSignatureData['cpm_trans_date']; ?>" name="cpm_trans_date">
        <input type="hidden" value="<?php echo $cpm_page_action; ?>" name="cpm_page_action">
        <p><input type="hidden" value="<?php echo $cpm_designation; ?>" name="cpm_designation"> </p>
        <input type="hidden" value="<?php echo $cpm_payment_config; ?>" name="cpm_payment_config">
        <input type="hidden" value="<?php echo $signature; ?>" name="signature">
        <input type="hidden" value="<?php echo $return_url; ?>" name="return_url">
        <input type="hidden" value="<?php echo $cancel_url; ?>" name="cancel_url">
        <input type="hidden" value="<?php echo $notify_url; ?>" name="notify_url">


                                    <button type="submit" class="btn btn-primary" style="">Confirmer</button>
                                </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 text-center">
            <hr/>
                <h4>Comment ça marche</h4>
            <hr/>
            <iframe width="100%" src="https://www.youtube.com/embed/DzH5aRoMYLw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

@endsection
