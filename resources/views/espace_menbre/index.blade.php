<?php

function convertCurrency($amount,$from_currency,$to_currency){
    $quotient_de_conversion = \App\Http\Controllers\CurrencyConverterController::recuperer_quotient_de_conversion($from_currency,$to_currency);
    return $quotient_de_conversion * $amount;
}

?>
@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
@endphp

@extends('espace_menbre.base_espace_menbre')

@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="mr-md-3 mr-xl-5">
                        <h2>Bienvenue <small>{{$le_menbre['nom_complet']}}.</small></h2>
                        {{-- <h4>1 {{$la_session['code_devise']}} = <?php  echo convertCurrency(1, $la_session['code_devise'], 'XOF'); ?> XOF</h4> --}}
{{--                        <p class="mb-md-0">Your analytics dashboard template.</p>--}}
                       
                        <h4 style="background-color:#fff;padding:5px"> Frais de gestion : {{$pourcentage_frais}}% </h4>

                    </div>
                    <div class="d-flex">
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    <a href="{{route('espace_menbre.ajouter_tontine')}}" type="button" class="btn btn-primary mr-3 mt-2 mt-xl-0">
                        <!--<i class="mdi mdi-plus text-muted"></i>-->
                        Nouvelle Tontine 
                    </a>

                    <a href="{{route('espace_menbre.creer_un_waricrowd')}}" class="btn btn-success mt-2 mt-xl-0">
                        <!--<i class="mdi mdi-plus text-muted"></i>-->
                        Créer un Waricrowd
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body dashboard-tabs p-0">
                    <ul class="nav nav-tabs px-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#"
                               role="tab" aria-controls="overview" aria-selected="true"></a>
                        </li>
                    </ul>
                    <div class="tab-content py-0 px-0">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <div class="d-flex flex-wrap justify-content-xl-between">
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('espace_menbre.liste_tontine')}}"> Mes Tontines </a> </small>
                                        <div class="dropdown">
                                            <h5 class="mb-0 d-inline-block">{{sizeof($le_menbre->tontines)}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('espace_menbre.liste_waricrowd')}}"> Mes Waricrowds </a> </small>
                                        <h5 class="mr-2 mb-0">{{sizeof($le_menbre->mes_waricrowd)}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('espace_menbre.invitations')}}">Mes Invitations</a></small>
                                        <h5 class="mr-2 mb-0">{{$nombre_invitation_recues}}</h5>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Adherer a une tontine via le code d'invitation</p>
                    <br/>
                    {!! Session::get('notification','') !!}
                    <form method="post" action="{{route('espace_menbre.confirmer_adhesion_tontine')}}">
                        <div class="row">
                            <div class="col-md-4">
                                <input class="form-control" type="number" name="code_invitation" required placeholder="Entrer le code d'invitation" />
                            </div>
                            <div class="col-md-4">
                                @csrf
                                <button type="submit" class="btn btn-success">Adherer à la tontine</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><a href="{{route('espace_menbre.profil',[$le_menbre->id])}}"> Solde </a></p>
                    <h1>{{number_format($le_menbre->compte->solde,0,',',' ')}} {{$la_session['devise']}}</h1>
                </div>
                <canvas id="total-sales-chart"></canvas>
            </div>
        </div>
    </div>


<button type="button" 
            class="btn btn-primary mr-2" 
            onclick="resumer_modal()" id="incitation_mdp" style="display:none"
            class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"
            >
            inciter au changement
        </button>
     {{-- MODAL RESUME --}}
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">CHANGEZ VOTRE MOT DE PASSE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <h5>Bonjour M/Mme {{$le_menbre['nom_complet']}}, Nous vous conseillons de changer votre mot de passe apres reinitialisation. </h5>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              <a href="{{route('espace_menbre.profil',[$le_menbre['id']])}}?action=mdp"  class="btn btn-success" >Changer mon mot de passe</a>
            </div>
          </div>
        </div>
    </div>


@endsection
@section('script_completmentaire')
    <script>
        window.onload = function() {
            fermer_tous_les_garde_fou();
            // alert("ks--s");
            setTimeout(() => {
                document.getElementById("close_on_dashboard_1").click();
                document.getElementById("close_on_dashboard_2").click();
                document.getElementById("close_on_dashboard_3").click();
                document.getElementById("close_on_dashboard_4").click();
                
                @if($le_menbre['incitation_mdp'] == 'oui')
                    document.getElementById("incitation_mdp").click();
                @endif
                
            }, 500);
            
        };

        function deplier_garde_fou(id){
            var le_garde_fou = document.getElementById(id);
            if(le_garde_fou.style.display =='none'){
                le_garde_fou.style.display = '';
            }else{
                le_garde_fou.style.display = 'none';
            }

        }

        function fermer_tous_les_garde_fou(){
            var tous_les_garde_fou = document.querySelectorAll('.garde_fou');
            for(var i=0; i<tous_les_garde_fou.length; i++){
                tous_les_garde_fou[i].style.display = "none";
            }
        }
    </script>
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
