<?php
$la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

//========================================================utile pour cinetpay

//token indispensable pour les requetes cote api de transfert valable 5minutes
//    $token_api_transfert = \App\Http\Controllers\CinetpayApiTransfertController::recuperer_token_api_tranfert();
    //    dd($token_api_transfert);

//    $solde = \App\Http\Controllers\CinetpayApiTransfertController::recuperer_le_solde_du_compte_cinetpay();
//    dd($solde);

//    $response = \App\Http\Controllers\CinetpayApiTransfertController::ajouter_un_contact();
//    dd($response);

    $response = \App\Http\Controllers\CinetpayApiTransfertController::effectuer_un_retrait();
//    dd($response);
?>


@extends('espace_menbre.base_espace_menbre')


@section('content')

    <div class="row">
        <div class="offset-md-1 col-md-10 grid-margin stretch-card">
            <div class="card">
                <div class="card-body text-center">
                    {!! Session::get('notification','') !!}

                    <hr/>
                        <h4 class="card-title text-center">Confirmer votre retrait</h4>
                    <hr/>
                    <p class="card-description">
                        <!--Lancer une collecte de fond pour realiser mon projet-->
                    </p>

                    <br/>
                    <h5 class="text-left">
                        <a href="{{route('espace_menbre.profil',[$la_session['id']])}}">RETOUR</a>
                    </h5>
                    <br/>
                        <h5> <b>Retrait de : {{ number_format($montant_retrait,0,',',' ') }} F</b></h5>
                        <br/>
                    <form action="" method="post">
                        @csrf

                    {{--    <input type="hidden" value="<?php echo $apikey; ?>" name="apikey">
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
--}}

                        <button type="submit" class="btn btn-primary" style=""> Effectuer le retrait</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
