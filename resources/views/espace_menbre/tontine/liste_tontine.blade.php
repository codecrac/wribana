
@extends('espace_menbre.base_espace_menbre')
@section('style_completmentaire')
    <style>
        .tr_bordered{
            border: 1px solid gray !important;
        }

        .clignote {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
@endsection
@section('content')

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <hr/>
                <h3 class="text-center">
                    Mes Tontines ( {{sizeof($mes_tontines)}} )
                    <a class="btn btn-success" href="{{route('espace_menbre.ajouter_tontine')}}">Creer une tontine</a>
                </h3>
                <hr/>

            </div>
            <br/><br/>
            <div class="row">
                <div class="table-responsive">
                    <table width="100%" class="table" border="1">
                        <thead class="text-center">
                        <th class="tr_bordered">Titre</th>
                        <th class="tr_bordered">Nombres de participants</th>
                        <th class="tr_bordered">Montant à cotiser</th>
                        <th class="tr_bordered">Statut</th>
                        <th class="tr_bordered">Prochaine cotisation</th>
                        <th class="tr_bordered">#</th>
                        </thead>
                        <tbody>
                        @foreach($mes_tontines as $ma_tontine)
                            <tr class="tr_bordered text-center">
                                <td class="tr_bordered">{{$ma_tontine['titre']}}</td>
                                <td class="tr_bordered">{{sizeof($ma_tontine->participants)}}/{{$ma_tontine['nombre_participant']}}</td>
                                <td class="tr_bordered">
                                    {{number_format($ma_tontine['montant'],0,',',' ')}} <b>{{$ma_tontine->createur->devise_choisie->monaie}}</b>
                                    <br/>
                                    {{formater_frequence($ma_tontine['frequence_depot_en_jours'])}}
                                </td>
                                <td class="tr_bordered text-danger">
                                    @php
                                      if($ma_tontine->etat == 'ouverte'){
                                            $couleur = 'success';
                                    }elseif ($ma_tontine->etat == 'prete'){
                                            $couleur = 'warning';
                                    }else{
                                        $couleur = 'danger';
                                    }
                                    @endphp
                                    <b class="badge badge-{{$couleur}}">
                                        {{$ma_tontine->etat}}
                                    </b>
                                </td>
                                <td class="tr_bordered">
                                        @if($ma_tontine->caisse !=null && $ma_tontine->etat =='ouverte')
                                            @php
                                                $aujourdhui = new DateTime("now", new \DateTimeZone("UTC"));
                                                $aujourdhui = $aujourdhui->format("d-m-Y");
                                                $aujourdhui = new DateTime($aujourdhui);

                                                $prochaine_date = $ma_tontine->caisse->prochaine_date_encaissement;
                                                $prochaine_date = new DateTime($prochaine_date);

                                                $interval = $prochaine_date->diff($aujourdhui);
                                                $intervals = $interval->format('%a');

                                                $prochaine_date_encaissement = $ma_tontine->caisse->prochaine_date_encaissement;
                                                $en_retard = time() >= strtotime($prochaine_date_encaissement) ;

                                            @endphp

                                            <br/>
                                            @if($en_retard)

                                            <span class="clignote badge badge-danger">
                                                Cotisation en retard
                                            </span>
                                            @else
                                                <b class="badge badge-warning">
                                                    Date limite dans {{$intervals}} jours
                                                </b>
                                                <br/><br/>
                                                <b class="badge badge-info">
                                                    Tour de : {{$ma_tontine->caisse->menbre_qui_prend->nom_complet}}
                                                </b>
                                            @endif
                                        @else
                                            #
                                        @endif
                                </td>
                                <td class="tr_bordered" style="padding: 8px">
                                    <a href="{{route('espace_menbre.details_tontine',[$ma_tontine['id']])}}" class="badge badge-primary">Details</a>
                                    <br/><br/>
                                    <a href="{{route('espace_menbre.chat_tontine',[$ma_tontine['id']])}}" class="badge badge-success">Espace Chat</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@php
    function formater_frequence($frequence_en_jour){

    $resultat = "chaque $frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7 ==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "chaque $nb_semaines semaine(s)";
            }
        }
        return $resultat;
    }
@endphp
