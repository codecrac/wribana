@extends('espace_menbre.base_espace_menbre')

@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="mr-md-3 mr-xl-5">
                        <h2>Bienvenue <small>{{$le_menbre['nom_complet']}}.</small></h2>
{{--                        <p class="mb-md-0">Your analytics dashboard template.</p>--}}
                    </div>
                    <div class="d-flex">
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    <a href="{{route('espace_menbre.ajouter_tontine')}}" type="button" class="btn btn-primary mr-3 mt-2 mt-xl-0">
                        <i class="mdi mdi-plus text-muted"></i>
                        Creer une tontine
                    </a>

                    <a href="{{route('espace_menbre.creer_un_waricrowd')}}" class="btn btn-success mt-2 mt-xl-0">
                        <i class="mdi mdi-plus text-muted"></i>
                        Lancer une collecte pour mon projet
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
                               role="tab" aria-controls="overview" aria-selected="true">#</a>
                        </li>
                    </ul>
                    <div class="tab-content py-0 px-0">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <div class="d-flex flex-wrap justify-content-xl-between">
                                <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
{{--                                    <i class="mdi mdi-calendar-heart icon-lg mr-3 text-primary"></i>--}}
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('espace_menbre.liste_tontine')}}"> Mes Tontines </a> </small>
                                        <div class="dropdown">
                                            <h5 class="mb-0 d-inline-block">{{sizeof($le_menbre->tontines)}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
{{--                                    <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i>--}}
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('espace_menbre.liste_waricrowd')}}"> Mes Waricrowds </a> </small>
                                        <h5 class="mr-2 mb-0">{{sizeof($le_menbre->mes_waricrowd)}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
{{--                                    <i class="mdi mdi-eye mr-3 icon-lg text-success"></i>--}}
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('espace_menbre.invitations')}}">Invitations reçues</a></small>
                                        <h5 class="mr-2 mb-0">{{$nombre_invitation_recues}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
{{--                                    <i class="mdi mdi-download mr-3 icon-lg text-warning"></i>--}}
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('espace_menbre.projets_soutenus')}}"> Projets Soutenus </a> </small>
                                        <h5 class="mr-2 mb-0">{{sizeof($le_menbre->projets_soutenus)}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i>
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('espace_menbre.profil',[$le_menbre->id])}}"> Solde </a> </small>
                                        <h5 class="mr-2 mb-0">{{number_format($le_menbre->compte->solde,0,',',' ')}} F</h5>
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
        <div class="col-md-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4 class="text-center card-title">Invitations reçues</h4>
                    {!! Session::get('notification','') !!}
                    <hr/>
                </div>
                <div class="card-body">
                    <p class="card-title">Adherer a une tontine via le code d'invitation</p>
                    <form method="post" action="{{route('espace_menbre.adhesion_via_code_invitation')}}">
                        <div class="row">
                            <div class="col-md-4">
                                <input class="form-control" type="number" name="code_invitation" required placeholder="Entrer le code d'invitation" />
                            </div>
                            <div class="col-md-4">
                                @csrf
                                <button type="submit" class="btn btn-success">Adherer</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="recent-purchases-listing" class="table">
                            <thead>
                            <tr>
                                <th class="tr_bordered">Envoyée par</th>
                                <th class="tr_bordered">Tontine</th>
                                <th class="tr_bordered">Montant a cotiser</th>
                                <th class="tr_bordered">Frequence de depot</th>
                                <th class="tr_bordered">Statut</th>
                                <th class="tr_bordered">#</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($invitation_recues as $item_iv_recue)

                                <tr>
                                    <td class="tr_bordered">{{$item_iv_recue->menbre_inviteur->nom_complet}}</td>
                                    <td class="tr_bordered">{{$item_iv_recue->tontine->titre}}</td>
                                    <td class="tr_bordered">{{number_format($item_iv_recue->tontine->montant,0,',',' ')}}</td>
                                    <td class="tr_bordered">{{formater_frequence($item_iv_recue->tontine->frequence_depot_en_jours)}} F</td>
                                    <td class="tr_bordered"><label class="badge badge-danger">{{$item_iv_recue['etat']}}</label></td>
                                    <td class="tr_bordered">
                                        <a href="#" onclick="deplier_garde_fou('garde_fou_recues_{{$item_iv_recue['id']}}')">Repondre</a>
                                        <div class="col-12 garde_fou" id="garde_fou_recues_{{$item_iv_recue['id']}}">
                                            <form method="post" action="{{route('espace_menbre.reponse_invitation',[$item_iv_recue['id']])}}">
                                                <select class="form-control" name="reponse" required>
                                                    <option value>(choisissez)</option>
                                                    <option value="acceptee">Accepter</option>
                                                    <option value="refusee">Refuser</option>
                                                </select>
                                                <br/>
                                                @csrf
                                                <input type="submit" value="valider" class="btn btn-warning">
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title"><a href="{{route('espace_menbre.profil',[$le_menbre->id])}}"> Solde </a></p>
                    <h1>{{number_format($le_menbre->compte->solde,0,',',' ')}} F</h1>
                </div>
                <canvas id="total-sales-chart"></canvas>
            </div>
        </div>
    </div>

@endsection
@section('script_completmentaire')
    <script>
        window.onload = function() {
            fermer_tous_les_garde_fou();
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
