<?php
$la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

$en_retard = false;
if ($la_tontine->caisse != null) {
    $prochaine_date_encaissement = $la_tontine->caisse->prochaine_date_encaissement;
    $en_retard = time() >= strtotime($prochaine_date_encaissement);
}

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

$cpm_amount = $la_tontine->montant; //TransactionAmount
$cpm_custom = "$notre_custom_field";// This field exist soanything can be inserted in it;it will be send back after payment

$cpm_designation = 'waribana-transaction'; //this field exist to identify the article being paid


$cpm_trans_date = date("Y-m-d H:i:s");
$cpm_trans_id = time() . (string)date("YmdHis"); //Transaction id that will be send to identify the transaction
$return_url = "https://waribana.jeberge.xyz/api/payer-ma-cotisation/reponse-tontine"; //The customer will be redirect on this page after successful payment
$cancel_url = "https://waribana.jeberge.xyz";//The customer will be redirect on this page if the payment get cancel
$notify_url = "";//This page must be a webhook (webservice).
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
try {
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
} catch (Exception $e) {
    $signature = 'uneErreurEstSurvenue';
}



?>


@extends('espace_menbre.base_espace_menbre')

@section('style_completmentaire')
    <style>
        .marquer_presence {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')

    {!! Session::get('notification','') !!}
    @isset($_GET['statut'])
        @if($_GET['statut'] == 'ACCEPTED')
            <div class='alert alert-success text-center'>Votre paiement a bien été</div>
        @else
            <div class='alert alert-danger text-center'>Echec du paiement</div>
        @endif
    @endisset
    {{-- SECTION A propos de la tontine et invitaion  --}}
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <a href="{{route('espace_menbre.liste_tontine')}}">RETOUR VERS LA LISTE</a>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('espace_menbre.chat_tontine',[$la_tontine['id']])}}"
                               class="badge badge-success">Espace Chat</a>
                        </div>
                    </div>
                    <hr/>
                    <h4 class="card-title text-center">
                        Tontine : {{$la_tontine->titre}}
                        @if($la_tontine->createur->id == $la_session['id'] && sizeof($la_tontine->transactions)==0)
                            <br/><br/>
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <a href="{{route('espace_menbre.editer_tontine',[$la_tontine['id']])}}"
                                       class="btn btn-warning">Editer la tontine</a>
                                </div>
                                <div class="col-md-6 text-center">
                                    <a href="{{route('espace_menbre.supprimer_tontine',[$la_tontine['id']])}}"
                                       class="btn btn-danger">Supprimer la tontine</a>
                                </div>
                            </div>
                        @endif
                        <br/>
                        @if($la_tontine->etat =='ouverte')
                            @if($en_retard)
                                <span class="clignote badge badge-danger">
                                            Cotisation en retard
                                        </span>
                            @endif
                        @endif
                    </h4>
                    <hr/>
                    <ul>
                        <li>Statut :
                            <mark
                                class="badge badge-{{$la_tontine->etat=='ouverte' ? 'success' :'danger'}}">{{$la_tontine->etat}}</mark>
                        </li>
                        @if($la_tontine->motif_intervention_admin !=null)
                            <li><b>Motif Intervention d'administrateur</b> :
                                <mark class="badge badge-info">{{$la_tontine->motif_intervention_admin}}</mark>
                            </li> @endif
                        <li>Crée par : {{$la_tontine->createur->nom_complet}}</li>
                        <li>Montant à cotiser : {{number_format($la_tontine->montant,0,',',' ')}}
                            <b>{{$la_tontine->createur->devise_choisie->symbole}}</b>
                            <small>par personnes</small></li>
                        @php
                            $montant_total = $la_tontine->montant * $la_tontine->nombre_participant;
                            $frais = round($montant_total * (1/100));
                        @endphp
                        <li>Montant Objectif : {{number_format($montant_total,0,',',' ')}}
                            <b>{{$la_tontine->createur->devise_choisie->symbole}}</b></li>
                        <li>Frais de gestion (1%) : {{number_format($frais,0,',',' ')}}
                            <b>{{$la_tontine->createur->devise_choisie->symbole}}</b>
                            / {{number_format($montant_total,0,',',' ')}}
                            <b>{{$la_tontine->createur->devise_choisie->symbole}}</b></li>
                        <li> Nombre de participant : {{sizeof($la_tontine->participants)}}
                            / {{$la_tontine->nombre_participant}} </li>
                        <li> Frequence de depot : {{formater_frequence($la_tontine->frequence_depot_en_jours)}}</li>
                        <li> Tour de :
                            <mark class="badge badge-primary marquer_presence">
                                @if($la_tontine->caisse !=null)
                                    {{$la_tontine->caisse->menbre_qui_prend->nom_complet}}
                                @else
                                    #
                                @endif
                            </mark>
                        </li>

                    </ul>


                    @if($la_tontine->createur->id == $la_session['id'] && $la_tontine->etat =='constitution' ||  $la_tontine->etat =='prete')
                        <p class="badge badge-info">La tontine pourra être ouverte une fois le nombre de participant
                            specifié atteinds.</p>
                        @if($pret)
                            <form method="post" action="{{route('espace_menbre.ouvrir_tontine',[$la_tontine['id']])}}">
                                @if($la_tontine->createur->id == $la_session['id'])
                                    @csrf
                                    <h3 class="text-center">
                                        <p class="badge badge-warning">Ouvrez la tontine uniquement si vous êtes pret a
                                            commencer les cotisations.</p>
                                        <button type="submit" class="btn btn-success">Ouvrir la tontine</button>
                                    </h3>
                                @endif
                            </form>
                        @else
                            <h3 class="text-center">
                                <input type="button" class="btn btn-dark" style="cursor: not-allowed"
                                       value="Ouvrir la tontine"/>
                            </h3>
                        @endif
                    @elseif($la_tontine->etat =='terminer')
                        {{--<p class="badge badge-success text-center">Votre tontine s'est effectuée avec succes vous(le createur) pouvez
                            la relancée!</p>
                        <form method="post" action="{{route('espace_menbre.ouvrir_tontine',[$la_tontine['id']])}}">
                            @if($la_tontine->createur->id == $la_session['id'])
                                @csrf
                                <h3 class="text-center">
                                    <p class="badge badge-warning">Ouvrez la tontine uniquement si vous êtes pret a
                                        commencer les cotisations.</p>
                                    <button type="submit" class="btn btn-success">Recommencer les cotisations</button>
                                </h3>
                            @endif
                        </form>--}}
                    @endif

                    <br/>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if($la_tontine->etat !='fermee' && $la_tontine->etat !='terminer')
                <div class="card">
                    <div class="card-body">
                        <hr>
                        <h4 class="text-uppercase text-center"> Inviter des amis </h4>
                        <hr>
                        @if(sizeof($la_tontine->participants) < $la_tontine->nombre_participant)
                            <br/>
                            <p class="card-description">
                                Code invitation : <b>{{$la_tontine->identifiant_adhesion}}</b> (a entrer dans la section
                                <b>adherer via code d'ivitation</b> sur le tableau de bord )
                                au personnes a inviter
                                <br/><br/>
                                ou Entrez la liste des emails separés des virgules(,)
                            </p>
                            <form class="forms-sample" method="post"
                                  action="{{route('espace_menbre.post_inviter_des_amis',[$la_tontine['id']])}}">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Liste des Emails</label>
                                    <input required type="text" class="form-control" name="liste_emails"
                                           placeholder="adresse1@gmail.com,adresse2@gmail.com">
                                </div>
                                <h3 class="text-center">
                                    @csrf
                                    <button type="submit" class="btn btn-primary mr-2">Envoyer les invitations</button>
                                </h3>
                            </form>
                        @else
                            <h3 class="text-center"><b class="badge badge-success">Complet !</b></h3>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Cotisation et rotation --}}
    @if($la_tontine->etat =='ouverte')
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <hr/>
                        <h4 class="text-center text-uppercase">
                            Cotisation courante
                            @if($en_retard)
                                <span class="clignote badge badge-danger">
                                    Cotisation en retard
                                </span>
                            @endif
                        </h4>
                        <hr/>
                        <br/>
                        <p>Tour de :
                            <b class="badge badge-info marquer_presence">
                                @if($la_tontine->caisse !=null)
                                    {{$la_tontine->caisse->menbre_qui_prend->nom_complet}}
                                @else
                                    #
                                @endif
                            </b>
                        </p>
                        <p>Date limite : <b
                                class="badge badge-warning"> {{$la_tontine->caisse->prochaine_date_encaissement}} </b>
                        </p>
                        {{--                        <p>Montant Total Objectif : <span class="marquer_presence text-dark">{{number_format( ($la_tontine->montant * $la_tontine->nombre_participant),0,',',' ')}} F</span> </p>--}}
                        <p>Montant à cotiser :
                            <b> {{number_format($la_tontine->montant,0,',',' ')}} {{$la_tontine->createur->devise_choisie->monaie}}</b>
                        </p>
                        <p>
                            Montant en caisse : <span class="marquer_presence text-info">
                                {{number_format($la_tontine->caisse->montant,0,',',' ')}} / {{number_format($la_tontine->caisse->montant_objectif,0,',',' ')}} <b>{{$la_tontine->createur->devise_choisie->monaie}}</b>
                            </span>
                        </p>
                        <p> de : <small> de {{sizeof($liste_ayant_cotiser)}}
                                personne(s)/{{sizeof($la_tontine->participants)}} <a href="#liste_cotiseur">Voir</a>
                            </small></p>
                        <br/>
                        @if($a_deja_cotiser)
                            <h5 class="text-center"><b style="padding: 15px" class="badge-success">Vous avez dejà payer
                                    votre cotisation pour ce tour.</b></h5>
                        @else
                            <h3 class="text-center">
                            <form action="{{route('espace_menbre.paiement_cotisation',[$la_tontine->id])}}" method="post">
                                {{--<form action="<?php echo $cpSecure; ?>" method="post">--}}
                        {{--            <input type="hidden" value="<?php echo $apikey; ?>" name="apikey">
                                    <p><input type="hidden" value="<?php echo $cpm_amount; ?>" name="cpm_amount"></p>
                                    <input type="hidden" value="<?php echo $cpm_custom; ?>" name="cpm_custom">
                                    <input type="hidden" value="<?php echo $cpm_site_id; ?>" name="cpm_site_id">
                                    <input type="hidden" value="<?php echo $cpm_version; ?>" name="cpm_version">
                                    <p><input type="hidden" value="<?php echo $cpm_currency; ?>" name="cpm_currency">
                                    </p>
                                    <input type="hidden" value="<?php echo $cpm_trans_id; ?>" name="cpm_trans_id">
                                    <input type="hidden" value="<?php echo $cpm_language; ?>" name="cpm_language">
                                    <input type="hidden" value="<?php echo $getSignatureData['cpm_trans_date']; ?>"
                                           name="cpm_trans_date">
                                    <input type="hidden" value="<?php echo $cpm_page_action; ?>" name="cpm_page_action">
                                    <p><input type="hidden" value="<?php echo $cpm_designation; ?>"
                                              name="cpm_designation"></p>
                                    <input type="hidden" value="<?php echo $cpm_payment_config; ?>"
                                           name="cpm_payment_config">
                                    <input type="hidden" value="<?php echo $signature; ?>" name="signature">
                                    <input type="hidden" value="<?php echo $return_url; ?>" name="return_url">
                                    <input type="hidden" value="<?php echo $cancel_url; ?>" name="cancel_url">--}}
                                <!--<input type="hidden" value="<?php echo $notify_url; ?>" name="notify_url">-->
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="">Payer ma cotisation</button>
                                </form>
                            </h3>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <hr/>
                        <h4 class="text-center text-uppercase">Ordre de rotation</h4>
                        <h6 class="text-center"><small> par date d'adhesion </small></h6>
                        <hr/>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <th>#</th>
                            <th>Menbre</th>
                            </thead>
                            <tbody>
                            @php $i=1; @endphp
                            @foreach($la_tontine->participants as $item_particpant)
                                <tr>
                                    <td>
                                        @if($la_tontine->caisse !=null)
                                            <b class="{{$la_tontine->caisse->menbre_qui_prend->id == $item_particpant->id ? 'badge badge-info' : '' }}">
                                                {{$i++}}
                                            </b>
                                        @endif
                                    </td>
                                    <td>{{$item_particpant->nom_complet}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Liste des personnes ayants cotisee et statut invitation envoye --}}
    <div class="row">
        @if($la_tontine->etat =='ouverte')
            <div class="col-md-6 grid-margin stretch-card" id="liste_cotiseur">
                <div class="card">
                    <div class="card-header">
                        <hr/>
                        <h4 class="text-center text-uppercase"> Personnes ayant payer leur cotisation </h4>
                        <hr/>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <th>Menbre</th>
                            <th>Date paiement</th>
                            </thead>
                            <tbody>
                            @foreach($liste_ayant_cotiser as $item_ayant_cotiser)
                                <tr>
                                    <td>{{$item_ayant_cotiser->cotiseur->nom_complet}}</td>
                                    <td>{{date("d/m/Y H:i",strtotime($item_ayant_cotiser->updated_at))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h4 class="text-center text-uppercase"> Invitations envoyees </h4>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <th>Email</th>
                        <th>Statut</th>
                        </thead>
                        <tbody>
                        @foreach($invitations_envoyees as $item_envoyee)
                            <tr>
                                <td>{{$item_envoyee->email_inviter}}</td>
                                <td>
                                    @php
                                        $couleur = "primary";
                                        if($item_envoyee->etat == "acceptee"){
                                            $couleur = "success";
                                        }elseif($item_envoyee->etat == "refusee"){
                                            $couleur = "danger";
                                        }elseif($item_envoyee->etat == "expiree"){
                                            $couleur = "dark";
                                        }
                                    @endphp
                                    <b class="badge badge-{{$couleur}}"> {{$item_envoyee->etat}} </b>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    function formater_frequence($frequence_en_jour){

    $resultat = "$frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "$nb_semaines semaines";
            }
        }
        return $resultat;
    }
@endphp
