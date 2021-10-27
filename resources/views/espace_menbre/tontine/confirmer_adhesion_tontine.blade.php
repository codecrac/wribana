<?php
$la_session = session(\App\Http\Controllers\MenbreController::$cle_session);


$monaie_createur_tontine = $la_tontine->createur->devise_choisie->code;
$monaie_utilisateur_connecter = $la_session['code_devise'];


$quotient_de_conversion =1; //on recupere le quotient puis on fais la conversion localement pour eviter de faire trop d'appel api
if($monaie_createur_tontine != $monaie_utilisateur_connecter){
    try{
        $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion($monaie_createur_tontine,$monaie_utilisateur_connecter);
    }catch(Exception $e){
        echo 'conversion des montant en cours';
        $quotient_de_conversion = 0;
    }
}

function convertir($quotient,$montant) //pour l'esthetic dans le code html
{
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
    $monaie_utilisateur_connecter = $la_session['devise'];
    $reponse =  \App\Http\Controllers\CurrencyConverterController::convertir_si_necessaire($quotient,$montant,$monaie_utilisateur_connecter);
    return $reponse;
}

?>


@extends('espace_menbre.base_espace_menbre')

@section('style_completmentaire')
    <style>
        .marquer_presence {
            font-size: 18px;
            font-weight: bold;
        }

        .show_on_mobile {
           display: none;
        }

        @media only screen and (max-width: 768px) {
            .show_on_mobile {
                display: inline-block;
            }
        }
    </style>
@endsection

@section('content')

    {!! Session::get('notification','') !!}
    {{-- SECTION A propos de la tontine et invitaion  --}}
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <a href="{{route('espace_menbre.liste_tontine')}}"> RETOUR </a>
                </div>
                <div class="card-body">
                    <hr/>
                    <h4 class="card-title text-center">
                        Tontine : {{$la_tontine->titre}}
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
                        <li>Montant à cotiser : 
                            {{number_format($la_tontine->montant,0,',',' ')}}
                            <b>{{$la_tontine->createur->devise_choisie->symbole}}</b>

                                {!!convertir($quotient_de_conversion,$la_tontine->montant,)!!}

                            <small>par personnes</small></li>
                        @php
                            $montant_total = $la_tontine->montant * $la_tontine->nombre_participant;
                            $frais = $montant_total * (1/100);
                        @endphp
                        <li>
                            Montant Objectif : {{number_format($montant_total,0,',',' ')}} <b>{{$la_tontine->createur->devise_choisie->symbole}}</b>  
                            {!!convertir($quotient_de_conversion,$montant_total,)!!}
                        </li>
                        <li>Frais de gestion (1%) : {{number_format($frais,2,',',' ')}}
                            <b>{{$la_tontine->createur->devise_choisie->symbole}}</b>
                            / {{number_format($montant_total,0,',',' ')}}
                            <b>{{$la_tontine->createur->devise_choisie->symbole}}</b></li>
                        <li> Nombre de participant : {{sizeof($la_tontine->participants)}}
                            / {{$la_tontine->nombre_participant}} </li>
                        <li> Frequence de depot : {{formater_frequence($la_tontine->frequence_depot_en_jours)}}</li>
                    </ul>


                    @if(sizeof($la_tontine->participants) < $la_tontine->nombre_participant)
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <form method="post" action="{{route('espace_menbre.adhesion_via_code_invitation')}}">
                                        <input class="form-control" value="{{$la_tontine->identifiant_adhesion}}" type="hidden" name="code_invitation" required 
                                            placeholder="Entrer le code d'invitation" />
                                        @csrf
                                        <button type="submit" class="btn btn-success">Continuer et Adherer</button>
                                    </form>
                                </div>
                                <div class="col-md-6 text-center">
                                    <a href="{{route('espace_menbre.accueil')}}" class="btn btn-danger"> Retour </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <h3 class="text-center"><b class="badge badge-success">Complet !</b></h3>
                    @endif

                    <br/>
                </div>
            </div>
        </div>

{{-- =============//===== INVITATIONS =================== --}}
        <div class="col-md-6">
            @if($la_tontine->etat !='fermee' && $la_tontine->etat !='terminer')
                <div class="card">
                    <div class="card-body">
                        <hr>
                        <h4 class="text-uppercase text-center"> Inviter des amis </h4>
                        <hr>
                        @php $le_lien = route('espace_menbre.liste_tontine').'?code_invitation='.$la_tontine->identifiant_adhesion @endphp
                        
                        Partager sur :
                        <br/>
                        
                        <a href="whatsapp://send?text=Bonjour je t'invite a rejoindre la tontine <<{{$la_tontine->titre}}>> sur WARIBANA via ce lien :
                        {{$le_lien}}"  class="btn btn-success show_on_mobile">Whatsapp</a>
                        
                        <a  class="btn btn-primary show_on_mobile" href="fb-messenger://share/?link=Bonjour je t'invite a rejoindre la tontine <<{{$la_tontine->titre}}>> sur WARIBANA via ce lien :
                        {{$le_lien}}">Messenger</a>
                        
                        <a class="btn btn-info" href="https://twitter.com/share?url={{$le_lien}}&text=Bonjour je t'invite a rejoindre la tontine <<{{$la_tontine->titre}}>> sur WARIBANA via ce lien :" 
                            target="_blank" title="Share on Twitter"> twitter</a>

                        
                       <a target="_blank" class="btn btn-primary" href="https://www.facebook.com/sharer/sharer.php?u={{$le_lien}}/&display=popup">
                         Facebook
                        </a>
                        
                        @if(sizeof($la_tontine->participants) < $la_tontine->nombre_participant)
                            
                            <hr/>
                                <h5 class="text-uppercase text-center"> ou utiliser </h5>
                            <hr/>
                                <p class="card-description">
                                    <b> le code invitation : {{$la_tontine->identifiant_adhesion}}</b>
                                <br/>
                                    <b>le lien d'adhesion</b> : {{$le_lien}} </p> <br/>
                            <hr/>
                                <h5 class="text-uppercase text-center"> Inviter via email </h5>
                            <hr/>

                            <form class="forms-sample" method="post"
                                  action="{{route('espace_menbre.post_inviter_des_amis',[$la_tontine['id']])}}">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Liste des Emails</label>
                                    <input required type="text" class="form-control text-lowercase" name="liste_emails"
                                           placeholder="adresse1@gmail.com,adresse2@gmail.com">
                                </div>
                                <h3 class="text-center">
                                    @csrf
                                    <button type="submit" class="btn btn-primary mr-2">Envoyer les invitations</button>
                                </h3>
                            </form>

                            <hr/>
                                <h5 class="text-uppercase text-center"> Inviter via sms </h5>
                            <hr/>
                            
                            <form class="forms-sample" method="post"
                                  action="{{route('espace_menbre.post_envoyer_invitation_via_sms',[$la_tontine['id']])}}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Prefixe</label><br/>
                                            <input required type="number" class="form-control text-lowercase" name="prefixe"
                                           placeholder="225,33...">
                                        </div>
                                        <div class="col-md-8">
                                            <label>Telephone</label><br/>
                                            <input required type="number" class="form-control text-lowercase" name="telephone"
                                           placeholder="0555005500">
                                        </div>
                                    </div>
                                </div>
                                <h3 class="text-center">
                                    @csrf
                                    <button type="submit" class="btn btn-primary mr-2 text-uppercase">Envoyer le SMS</button>
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
